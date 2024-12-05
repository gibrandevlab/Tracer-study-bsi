@extends('layouts.Dashboard.dashboard')

@section('title', 'Admin - SITRA BSI')

@section('content')
    @if ($peranPengguna == 'admin')
        <div class="min-h-screen flex flex-col flex-auto flex-shrink-0 antialiased bg-white dark:bg-gray-800 text-black dark:text-white">
            @include('layouts.Dashboard.navbaratas')
            @include('layouts.Dashboard.sidebarkiri')

            <div class="h-full ml-14 mt-14 mb-10 md:ml-64 p-6">
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    @include('components.dashboard.Event Setting.table-event', ['users' => $users])
                </div>
            </div>
        </div>
    @endif
@endsection
