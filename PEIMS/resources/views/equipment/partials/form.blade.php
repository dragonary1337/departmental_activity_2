<div class="space-y-5">
    <div>
        <label for="equipment_name" class="block text-sm font-medium text-slate-700">Equipment name</label>
        <input id="equipment_name" name="equipment_name" value="{{ old('equipment_name', $equipment->equipment_name) }}" required maxlength="255" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
        @error('equipment_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="category" class="block text-sm font-medium text-slate-700">Category</label>
            <select id="category" name="category" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
                <option value="">Select a category</option>
                @foreach (\App\Models\Equipment::CATEGORIES as $category)
                    <option value="{{ $category }}" @selected(old('category', $equipment->category) === $category)>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="unit_price" class="block text-sm font-medium text-slate-700">Unit price</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <span class="inline-flex items-center rounded-l-md border border-r-0 border-slate-300 bg-slate-50 px-3 text-slate-500">$</span>
                <input id="unit_price" name="unit_price" type="number" step="0.01" min="0" max="99999999.99" value="{{ old('unit_price', $equipment->unit_price) }}" required class="block w-full rounded-r-md border-slate-300 focus:border-emerald-600 focus:ring-emerald-600">
            </div>
            @error('unit_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
    <div>
        <label for="description" class="block text-sm font-medium text-slate-700">Description and specifications</label>
        <textarea id="description" name="description" rows="4" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">{{ old('description', $equipment->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="availability_status" class="block text-sm font-medium text-slate-700">Availability</label>
        <select id="availability_status" name="availability_status" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="">Select availability</option>
            @foreach (\App\Models\Equipment::AVAILABILITY_STATUSES as $status)
                <option value="{{ $status }}" @selected(old('availability_status', $equipment->availability_status) === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('availability_status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    @if ($errors->any())
        <div class="rounded-md bg-red-50 p-4 text-sm text-red-700" role="alert">
            Please correct the highlighted fields and try again.
        </div>
    @endif
</div>
