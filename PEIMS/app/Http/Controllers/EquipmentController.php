<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(): View
    {
        $equipment = auth()->user()->equipment()->latest()->paginate(10);

        return view('equipment.index', compact('equipment'));
    }

    public function create(): View
    {
        return view('equipment.create', ['equipment' => new Equipment]);
    }

    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        // The owner comes from the authenticated relationship, never from form input.
        auth()->user()->equipment()->create($request->validated());

        return redirect()->route('equipment.index')->with('status', 'Equipment added successfully.');
    }

    public function show(Equipment $equipment): View
    {
        $equipment = $this->ownedEquipment($equipment);

        return view('equipment.show', compact('equipment'));
    }

    public function edit(Equipment $equipment): View
    {
        $equipment = $this->ownedEquipment($equipment);

        return view('equipment.edit', compact('equipment'));
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $this->ownedEquipment($equipment)->update($request->validated());

        return redirect()->route('equipment.index')->with('status', 'Equipment updated successfully.');
    }

    public function destroy(Equipment $equipment): RedirectResponse
    {
        $this->ownedEquipment($equipment)->delete();

        return redirect()->route('equipment.index')->with('status', 'Equipment deleted successfully.');
    }

    private function ownedEquipment(Equipment $equipment): Equipment
    {
        return auth()->user()->equipment()->findOrFail($equipment->getKey());
    }
}
