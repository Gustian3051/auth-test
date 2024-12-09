@extends('layouts.app')

@section('content')
    @include('partials.navbar.admin-staff-navbar')
    <div class="p-4 mt-3 sm:ml-64">
        <div class="space-y-4 rounded-lg mt-14">
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <p class="text-lg font-semibold text-green-500">Admin & Staff</p>
            </div>
            <div class="p-4 bg-white rounded-lg shadow-lg">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                    <div>
                        <canvas id="peminjamanChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
