@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold">Greetings, {{ Auth::user()->name }}!</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
