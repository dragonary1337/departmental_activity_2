@extends('layouts.master')

@section('title', 'Equipment reports')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Insights</p>
        <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Equipment reports</h1>
        <p class="mt-2 text-slate-600">View saved inventory records, apply filters, and export the same result set.</p>
    </div>

    <form method="GET" action="{{ route('reports.index') }}" class="mb-6 grid gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
        <div>
            <label for="report_type" class="block text-sm font-medium text-slate-700">Report</label>
            <select id="report_type" name="report_type" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="price_list" @selected($filters['report_type'] === 'price_list')>Equipment price list</option>
                <option value="available" @selected($filters['report_type'] === 'available')>Available equipment</option>
                <option value="unavailable" @selected($filters['report_type'] === 'unavailable')>Unavailable equipment</option>
                <option value="by_category" @selected($filters['report_type'] === 'by_category')>Equipment by category</option>
            </select>
            @error('report_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="category" class="block text-sm font-medium text-slate-700">Category</label>
            <select id="category" name="category" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">All categories</option>
                @foreach (\App\Models\Equipment::CATEGORIES as $category)
                    <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="availability_status" class="block text-sm font-medium text-slate-700">Availability</label>
            <select id="availability_status" name="availability_status" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">All statuses</option>
                @foreach (\App\Models\Equipment::AVAILABILITY_STATUSES as $status)
                    <option value="{{ $status }}" @selected(($filters['availability_status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            @error('availability_status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 font-semibold text-white hover:bg-emerald-800">Apply filters</button>
            <a href="{{ route('reports.index') }}" class="rounded-md border border-slate-300 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
        </div>
    </form>

    <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 px-5 py-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $equipment->count() }} {{ \Illuminate\Support\Str::plural('record', $equipment->count()) }} match the selected filters.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.pdf', request()->query()) }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Export PDF</a>
                <a href="{{ route('reports.excel', request()->query()) }}" class="rounded-md bg-emerald-700 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Export Excel</a>
            </div>
        </div>
        @if ($equipment->isEmpty())
            <p class="px-6 py-12 text-center text-slate-600">No equipment records match the selected filters.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Equipment name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Unit price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Availability</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($equipment as $item)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-900">{{ $item->equipment_name }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">{{ ucfirst($item->category) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-900">${{ number_format((float) $item->unit_price, 2) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">{{ ucfirst($item->availability_status) }}</td>
                                <td class="min-w-64 px-6 py-4 text-sm text-slate-600">{{ $item->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
