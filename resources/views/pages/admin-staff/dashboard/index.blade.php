@extends('layouts.app')

@section('content')
@include('partials.navbar.admin-staff-navbar')

<div class="p-5 mt-1 sm:ml-64">
    <div class="space-y-4 rounded-lg mt-14">
        <div class="p-4 bg-white rounded-lg shadow-lg">
            <p class="text-lg font-semibold text-green-500">Dashboard</p>
        </div>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-4">
            <div>
                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold">Dosen</p>
                            <p class="text-xl font-semibold"></p>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-blue-500">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold">Mahasiswa</p>
                            <p class="text-xl font-semibold"></p>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-green-500">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold">Alat & Bahan</p>
                            <p class="text-xl font-semibold"></p>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-yellow-500">
                                <i class="fa-solid fa-microscope"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="p-4 bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold">Ruangan</p>
                            <p class="text-xl font-semibold"></p>
                        </div>
                        <div>
                            <div class="text-3xl font-semibold text-red-500">
                                <i class="fa-solid fa-pump-medical"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-lg">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div>
                    <canvas id="peminjamanChart" width="400" height="200"></canvas>
                </div>
                <div>
                    <canvas id="mahasiswaChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-lg">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div>
                    <canvas id="alatChart" width="400" height="200"></canvas>
                </div>
                <div>
                    <canvas id="bahanChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
