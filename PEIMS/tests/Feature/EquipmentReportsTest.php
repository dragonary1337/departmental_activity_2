<?php

use App\Models\Equipment;
use App\Models\User;

function createReportEquipment(User $user, string $name, string $category, string $status): Equipment
{
    return $user->equipment()->create([
        'equipment_name' => $name,
        'category' => $category,
        'unit_price' => '12.50',
        'description' => "$name inventory record.",
        'availability_status' => $status,
    ]);
}

test('category and availability filters work together and can be reset', function () {
    $user = User::factory()->create();
    createReportEquipment($user, 'Available Paddle', 'paddles', 'available');
    createReportEquipment($user, 'Unavailable Paddle', 'paddles', 'unavailable');
    createReportEquipment($user, 'Available Ball', 'balls', 'available');

    $this->actingAs($user)
        ->get(route('reports.index', ['category' => 'paddles', 'availability_status' => 'available']))
        ->assertOk()
        ->assertSee('Available Paddle')
        ->assertDontSee('Unavailable Paddle')
        ->assertDontSee('Available Ball');

    $this->get(route('reports.index'))->assertOk()
        ->assertSee('Available Paddle')
        ->assertSee('Unavailable Paddle')
        ->assertSee('Available Ball');
});

test('available report and exports honor filters and handle empty results', function () {
    $user = User::factory()->create();
    createReportEquipment($user, 'Available Paddle', 'paddles', 'available');
    createReportEquipment($user, 'Unavailable Paddle', 'paddles', 'unavailable');
    $this->actingAs($user);
    $filters = [
        'report_type' => 'available',
        'category' => 'paddles',
        'availability_status' => 'available',
    ];

    $this->get(route('reports.index', $filters))
        ->assertOk()
        ->assertSee('Available Paddle')
        ->assertDontSee('Unavailable Paddle');

    $pdf = $this->get(route('reports.pdf', $filters));
    $pdf->assertOk()->assertDownload('peims-equipment-report.pdf');

    $excel = $this->get(route('reports.excel', $filters));
    $excel->assertOk()->assertDownload('peims-equipment-report.xlsx');

    $this->get(route('reports.index', [
        'report_type' => 'unavailable',
        'availability_status' => 'available',
    ]))->assertOk()
        ->assertSee('No equipment records match the selected filters.');
});
