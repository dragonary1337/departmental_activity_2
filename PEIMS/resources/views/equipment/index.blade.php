@extends('layouts.master')

@section('title', 'Equipment inventory')

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">Inventory</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Equipment</h1>
            <p class="mt-2 text-slate-600">Manage pickleball equipment and availability.</p>
        </div>
        <a href="{{ route('equipment.create') }}" class="rounded-md bg-emerald-700 px-4 py-2.5 font-semibold text-white shadow-sm hover:bg-emerald-800">Add equipment</a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        @if ($equipment->isEmpty())
            <div class="px-6 py-14 text-center">
                <h2 class="text-lg font-semibold text-slate-900">No equipment yet</h2>
                <p class="mt-2 text-slate-600">Add your first inventory record to get started.</p>
                <a href="{{ route('equipment.create') }}" class="mt-5 inline-flex rounded-md bg-emerald-700 px-4 py-2 text-white hover:bg-emerald-800">Add equipment</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Equipment</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Unit price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Availability</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($equipment as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <a class="font-semibold text-slate-900 hover:text-emerald-700" href="{{ route('equipment.show', $item) }}">{{ $item->equipment_name }}</a>
                                    <p class="mt-1 max-w-md truncate text-sm text-slate-500">{{ $item->description }}</p>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">{{ ucfirst($item->category) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">${{ number_format((float) $item->unit_price, 2) }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->availability_status === 'available' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($item->availability_status) }}</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                    <a class="font-semibold text-emerald-700 hover:text-emerald-900" href="{{ route('equipment.edit', $item) }}">Edit</a>
                                    <form class="ml-3 inline" method="POST" action="{{ route('equipment.destroy', $item) }}" data-confirm="Delete {{ $item->equipment_name }}? This action cannot be undone." onsubmit="return confirm(this.dataset.confirm);">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-semibold text-red-700 hover:text-red-900" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">{{ $equipment->links() }}</div>
        @endif
    </div>
@endsection
