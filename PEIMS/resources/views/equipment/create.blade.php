@extends('layouts.master')

@section('title', 'Add equipment')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('equipment.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">&larr; Back to equipment</a>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Add equipment</h1>
        <p class="mt-2 text-slate-600">Enter the inventory details below.</p>
        <form class="mt-6 space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm" method="POST" action="{{ route('equipment.store') }}">
            @csrf
            @include('equipment.partials.form')
            <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('equipment.index') }}" class="rounded-md border border-slate-300 px-4 py-2 font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button class="rounded-md bg-emerald-700 px-4 py-2 font-semibold text-white hover:bg-emerald-800" type="submit">Save equipment</button>
            </div>
        </form>
    </div>
@endsection
