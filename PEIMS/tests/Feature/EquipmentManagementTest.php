<?php

use App\Models\Equipment;
use App\Models\User;

function equipmentPayload(array $overrides = []): array
{
    return array_merge([
        'equipment_name' => 'Carbon Fiber Paddle',
        'category' => 'paddles',
        'unit_price' => '89.99',
        'description' => '16 mm carbon-fiber face with polymer honeycomb core.',
        'availability_status' => 'available',
    ], $overrides);
}

test('guests cannot access inventory or reports', function () {
    $this->get(route('equipment.index'))->assertRedirect(route('login'));
    $this->get(route('reports.index'))->assertRedirect(route('login'));
});

test('authenticated users can create and manage only their own equipment', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($owner)->post(route('equipment.store'), equipmentPayload([
        'user_id' => $otherUser->id,
    ]))->assertRedirect(route('equipment.index'));

    $equipment = Equipment::firstOrFail();
    expect($equipment->user_id)->toBe($owner->id);

    $this->get(route('equipment.show', $equipment))->assertOk()->assertSee($equipment->equipment_name);
    $this->get(route('equipment.edit', $equipment))->assertOk();
    $this->put(route('equipment.update', $equipment), equipmentPayload([
        'equipment_name' => 'Updated Paddle',
    ]))->assertRedirect(route('equipment.index'));

    $this->actingAs($otherUser)->get(route('equipment.show', $equipment))->assertNotFound();
    $this->actingAs($owner)->delete(route('equipment.destroy', $equipment))->assertRedirect(route('equipment.index'));
    $this->assertDatabaseMissing('equipment', ['id' => $equipment->id]);
});

test('invalid equipment data is rejected and old input is retained', function () {
    $this->actingAs(User::factory()->create())
        ->from(route('equipment.create'))
        ->post(route('equipment.store'), equipmentPayload([
            'unit_price' => '-1.00',
            'category' => 'courts',
        ]))
        ->assertRedirect(route('equipment.create'))
        ->assertSessionHasErrors(['unit_price', 'category'])
        ->assertSessionHas('_old_input.equipment_name', 'Carbon Fiber Paddle');

    $this->assertDatabaseCount('equipment', 0);
});
