<div id="form-peminjaman" tabindex="-1"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    Form Peminjaman
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="form-peminjaman">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (Auth::guard('mahasiswa')->check())
                        <div class="mb-5">
                            <label for="nama"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Lengkap/Ketua Kelompok</label>
                            <input type="nama" id="nama" value="{{ auth()->user()->nama }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-5">
                            <label for="anggota_kelompok"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Anggota</label>
                            <textarea id="anggota_kelompok" rows="4" name="anggota_kelompok"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-5">
                            <label for="kelas_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                            <input type="kelas_id" id="kelas_id" value="{{ auth()->user()->kelas }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        {{-- START SELECT DOSEN --}}
                        <div class="mb-5">
                            <label for="dosen_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dosen</label>
                            <select id="dosen_id" name="dosen_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Dosen Pengampu</option>
                                @foreach ($dosen as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                            @error('dosen_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- END SELECT DOSEN --}}

                        <div class="mb-5">
                            <label for="matkul_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata
                                Kuliah</label>
                            <select id="matkul_id" name="matkul_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Mata Kuliah</option>
                                @foreach ($matkul as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_matkul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="ruangan_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruang
                                Praktikum</label>
                            <select id="ruangan_id" name="ruangan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Pilih Ruang Praktikum</option>
                                @foreach ($ruangLaboratorium as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="tanggal_waktu_peminjaman"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal & Waktu Peminjaman
                            </label>
                            <input type="datetime-local" name="tanggal_waktu_peminjaman" id="tanggal_waktu_peminjaman"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="waktu_pengembalian"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Waktu Pengembalian
                            </label>
                            <input type="time" name="waktu_pengembalian" id="waktu_pengembalian"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div class="mb-5">
                            <label for="dokumen_spo_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dokumen SPO</label>
                            <select id="dokumen_spo_id" name="dokumen_spo_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected>Dokumen SPO</option>
                                @foreach ($dokumenSpo as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_dokumen }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <ul>
                                    @foreach ($dokumenSpo as $data)
                                        <li>
                                            <a href="{{ asset('storage/' . $data->file_path) }}" download
                                                class="text-blue-500 hover:underline text-sm">
                                                Download {{ $data->nama_dokumen }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @elseif(Auth::guard('dosen')->check())
                        <div class="mb-5">
                            <label for="nama"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                Dosen</label>
                            <input type="nama" id="nama" value="{{ auth()->user()->nama }}" disabled
                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="tanggal_waktu_peminjaman"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal & Waktu Peminjaman
                            </label>
                            <input type="datetime-local" name="tanggal_waktu_peminjaman" id="tanggal_waktu_peminjaman"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="waktu_pengembalian"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Waktu Pengembalian
                            </label>
                            <input type="time" name="waktu_pengembalian" id="waktu_pengembalian"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>

                        <div class="mb-5">
                            <label for="keterangan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                    @endif

                    <button data-modal-hide="form-peminjaman" type="submit"
                        class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
