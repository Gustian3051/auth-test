<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 mt-3 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @if (Auth::user()->hasAnyRole(['Admin' , 'Staff']))
            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center p-2 rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group {{ Route::is('dashboard.index') ? 'bg-green-500 text-white' : '' }}">
                    <i class="fa-solid fa-table-columns"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('Admin'))
                <li>
                    <a class="flex items-center w-full p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group transition duration-75 {{ Request::is('pengguna/*') ? 'bg-green-500 text-white' : '' }}"
                        aria-controls="pengguna" data-collapse-toggle="pengguna">
                        <i class="fa-solid fa-users"></i>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Pengguna</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </a>
                    <ul id="pengguna" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('admin-staff.index') }}"
                                class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('admin-staff.index') ? 'bg-green-500 text-white' : '' }}">Admin
                                dan Staff</a>
                        </li>
                        <li>
                            <a href="{{ route('mahasiswa.index') }}"
                                class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('mahasiswa.index') ? 'bg-green-500 text-white' : '' }}">Mahasiswa</a>
                        </li>
                        <li>
                            <a href="{{ route('dosen.index') }}"
                                class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('dosen.index') ? 'bg-green-500 text-white' : '' }}">Dosen</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('mata-kuliah.index') }}"
                        class="flex items-center p-2 rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group {{ Route::is('mata-kuliah.index') ? 'bg-green-500 text-white' : '' }}">
                        <i class="fa-solid fa-book"></i>
                        <span class="ms-3">Mata Kuliah</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dokumen-spo.index') }}"
                        class="flex items-center p-2 rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group {{ Route::is('dokumen-spo.index') ? 'bg-green-500 text-white' : '' }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span class="ms-3">Dokumen SPO</span>
                    </a>
                </li>

            @endif
            @if (Auth::user()->hasRole('Staff'))
            <li>
                <a class="flex items-center w-full p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group transition duration-75 {{ Request::is('alat-bahan/*') ? 'bg-green-500 text-white' : '' }}"
                    aria-controls="alat-bahan" data-collapse-toggle="alat-bahan">
                    <i class="fa-solid fa-users"></i>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Alat & Bahan</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </a>
                <ul id="alat-bahan" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('barang.index') }}"
                            class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('alat-bahan.index') ? 'bg-green-500 text-white' : '' }}">Barang</a>
                    </li>
                    <li>
                        <a href="{{ route('satuan.index') }}"
                            class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('satuan.index') ? 'bg-green-500 text-white' : '' }}">Satuan</a>
                    </li>
                    <li>
                        <a href="{{ route('kategori.index') }}"
                            class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('kategori.index') ? 'bg-green-500 text-white' : '' }}">Kategori</a>
                    </li>
                </ul>
            </li>
                <li>
                    <a href="{{ route('ruang-laboratorium.index') }}"
                        class="flex items-center p-2 rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group {{ Route::is('ruang-laboratorium.index') ? 'bg-green-500 text-white' : '' }}">
                        <i class="fa-solid fa-table-columns"></i>
                        <span class="ms-3">Ruang Laboratorium</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center w-full p-2  rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group transition duration-75 {{ Request::is('pengguna/*') ? 'bg-green-500 text-white' : '' }}"
                        aria-controls="verifikasi" data-collapse-toggle="verifikasi">
                        <i class="fa-solid fa-users"></i>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Verifikasi</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </a>
                    <ul id="verifikasi" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('verifikasi-peminjaman.index') }}"
                                class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('verifikasi-peminjaman.index') ? 'bg-green-500 text-white' : '' }}">Peminjaman</a>
                        </li>
                        <li>
                            <a href="{{ route('verifikasi-pengembalian.index') }}"
                                class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group dark:text-gray-100 hover:bg-green-800 hover:text-white {{ Route::is('verifikasi-pengembalian.index') ? 'bg-green-500 text-white' : '' }}">Pengembalian</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->hasAnyRole(['Admin' , 'Staff']))
                <li>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center p-2 rounded-lg dark:text-gray-100 hover:bg-green-800 hover:text-white group {{ Route::is('laporan.index') ? 'bg-green-500 text-white' : '' }}">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span class="ms-3">Laporan</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>
