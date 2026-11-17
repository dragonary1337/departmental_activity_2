<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EquipmentReportController extends Controller
{
    private const REPORT_TYPES = ['price_list', 'available', 'unavailable', 'by_category'];

    public function index(Request $request): View
    {
        [$filters, $equipment, $title] = $this->reportData($request);

        return view('reports.index', compact('filters', 'equipment', 'title'));
    }

    public function pdf(Request $request): StreamedResponse
    {
        [$filters, $equipment, $title] = $this->reportData($request);
        $pdf = new Dompdf;
        $pdf->loadHtml(view('reports.export', compact('equipment', 'title', 'filters'))->render());
        $pdf->setPaper('a4', 'landscape');
        $pdf->render();
        $contents = $pdf->output();

        return response()->streamDownload(
            static fn () => print $contents,
            'peims-equipment-report.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    public function excel(Request $request): BinaryFileResponse
    {
        [$filters, $equipment, $title] = $this->reportData($request);
        $path = tempnam(sys_get_temp_dir(), 'peims-report-');
        if ($path === false) {
            throw new \RuntimeException('Unable to create a temporary Excel report file.');
        }

        $writer = new Writer;
        $writer->openToFile($path);
        $writer->addRow(Row::fromValues([
            'Equipment Name', 'Category', 'Unit Price', 'Availability', 'Description',
        ]));
        foreach ($equipment as $item) {
            $writer->addRow(Row::fromValues([
                $item->equipment_name,
                ucfirst($item->category),
                $item->unit_price,
                ucfirst($item->availability_status),
                $item->description,
            ]));
        }
        $writer->close();

        return response()->download($path, 'peims-equipment-report.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Filters are shared by the report screen and both export formats.
     *
     * @return array{array<string, string>, Collection<int, Equipment>, string}
     */
    private function reportData(Request $request): array
    {
        $filters = $request->validate([
            'report_type' => ['nullable', Rule::in(self::REPORT_TYPES)],
            'category' => ['nullable', Rule::in(Equipment::CATEGORIES)],
            'availability_status' => ['nullable', Rule::in(Equipment::AVAILABILITY_STATUSES)],
        ]);
        $filters['report_type'] = $filters['report_type'] ?? 'price_list';
        if ($filters['report_type'] === 'by_category' && empty($filters['category'])) {
            validator($filters, ['category' => ['required', Rule::in(Equipment::CATEGORIES)]])->validate();
        }

        $titles = [
            'price_list' => 'Equipment Price List',
            'available' => 'Available Equipment',
            'unavailable' => 'Unavailable Equipment',
            'by_category' => 'Equipment by Category',
        ];
        $query = auth()->user()->equipment()->orderBy('equipment_name');

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (! empty($filters['availability_status'])) {
            $query->where('availability_status', $filters['availability_status']);
        }
        if (in_array($filters['report_type'], ['available', 'unavailable'], true)) {
            $query->where('availability_status', $filters['report_type']);
        }

        return [$filters, $query->get(), $titles[$filters['report_type']]];
    }
}
