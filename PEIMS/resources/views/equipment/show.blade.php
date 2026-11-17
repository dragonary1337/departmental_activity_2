@extends('layouts.master')

@section('title', $equipment->equipment_name)

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('equipment.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">&larr; Back to equipment</a>
        <div class="mt-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-emerald-700">{{ ucfirst($equipment->category) }}</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $equipment->equipment_name }}</h1>
                </div>
                <span class="rounded-full px-3 py-1.5 text-sm font-semibold {{ $equipment->availability_status === 'available' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($equipment->availability_status) }}</span>
            </div>
            <dl class="mt-8 grid gap-6 border-t border-slate-100 pt-6 sm:grid-cols-2">
                <div><dt class="text-sm font-medium text-slate-500">Unit price</dt><dd class="mt-1 text-lg font-semibold text-slate-900">${{ number_format((float) $equipment->unit_price, 2) }}</dd></div>
                <div><dt class="text-sm font-medium text-slate-500">Created</dt><dd class="mt-1 text-slate-900">{{ $equipment->created_at->format('M j, Y') }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-sm font-medium text-slate-500">Description and specifications</dt><dd class="mt-2 whitespace-pre-line text-slate-800">{{ $equipment->description }}</dd></div>
            </dl>
            <div class="mt-8 flex justify-end border-t border-slate-100 pt-5">
                <a href="{{ route('equipment.edit', $equipment) }}" class="rounded-md bg-emerald-700 px-4 py-2 font-semibold text-white hover:bg-emerald-800">Edit equipment</a>
            </div>
        </div>
    </div>
@endsection
