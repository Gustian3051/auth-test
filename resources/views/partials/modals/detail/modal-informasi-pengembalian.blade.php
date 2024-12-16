<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pengembalian
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="detail{{ $data->id }}">
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
                <form action="{{ route('pengembalian.proses', $data->id) }}" method="POST">
                    @csrf
                    @foreach ($data->peminjamanDetail as $detail)
                        <div class="max-w-screen-xl mx-auto">
                            <div class="w-full bg-white border border-gray-200 rounded-lg shadow p-3">
                                <div class="flex justify-between">
                                    <!-- Informasi Barang -->
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($detail->foto ?? 'image/barang.png') }}" class="w-12"
                                            alt="Gambar">
                                        <div>
                                            <p class="text-sm font-semibold">{{ $detail->alatBahan->nama }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $detail->alatBahan->kategori->kategori }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p>Jumlah yang di pinjam: {{ $detail->jumlah }}</p>
                                </div>
                                <div class="mb-2 mt-5">
                                    <!-- Input Status -->
                                    <label for="kondisi_{{ $detail->id }}"
                                        class="block mt-2 text-sm font-medium">Kondisi Barang</label>
                                    <select id="kondisi_{{ $detail->id }}" name="kondisi[{{ $detail->id }}]"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500"
                                        onchange="tampilkanInput({{ $detail->id }})">
                                        <option value="Hilang">Hilang</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Habis">Habis</option>
                                        <option value="Dikembalikan">Dikembalikan</option>
                                    </select>
                                </div>

                                <!-- Input untuk jumlah hilang -->
                                <div class="hidden">
                                    <label for="jumlah_hilang_{{ $detail->id }}"
                                        class="block text-sm font-medium">Jumlah Hilang</label>
                                    <input type="number" name="jumlah_hilang[{{ $detail->id }}]"
                                        id="jumlah_hilang_{{ $detail->id }}" min="0"
                                        max="{{ $detail->jumlah }}" placeholder="Masukkan Jumlah yang Hilang"
                                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>

                                <!-- Input untuk jumlah rusak -->
                                <div class="hidden">
                                    <label for="jumlah_rusak_{{ $detail->id }}"
                                        class="block text-sm font-medium">Jumlah Rusak</label>
                                    <input type="number" name="jumlah_rusak[{{ $detail->id }}]"
                                        id="jumlah_rusak_{{ $detail->id }}" min="0"
                                        max="{{ $detail->jumlah }}" placeholder="Masukkan Jumlah yang Rusak"
                                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>

                                <!-- Input untuk jumlah habis -->
                                <div class="hidden">
                                    <label for="jumlah_habis_{{ $detail->id }}"
                                        class="block text-sm font-medium">Jumlah Habis</label>
                                    <input type="number" name="jumlah_habis[{{ $detail->id }}]"
                                        id="jumlah_habis_{{ $detail->id }}" min="0"
                                        max="{{ $detail->jumlah }}" placeholder="Masukkan Jumlah yang Habis"
                                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="mt-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-900 dark:text-white">
                            Tindakan yang sudah dilakukan
                        </label>
                        <textarea id="catatan" rows="4" name="catatan"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"placeholder="Masukkan tindakan SPO">
                        </textarea>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Ajukan Pengembalian
                    </button>
                </form>
            </div>

            <script>
                function tampilkanInput(detailId) {
                    // Ambil nilai kondisi yang dipilih
                    var kondisi = document.getElementById('kondisi_' + detailId).value;

                    // Ambil elemen input untuk jumlah hilang, rusak, dan habis
                    var jumlahHilang = document.getElementById('jumlah_hilang_' + detailId);
                    var jumlahRusak = document.getElementById('jumlah_rusak_' + detailId);
                    var jumlahHabis = document.getElementById('jumlah_habis_' + detailId);

                    // Sembunyikan semua input terlebih dahulu
                    jumlahHilang.parentElement.classList.add('hidden');
                    jumlahRusak.parentElement.classList.add('hidden');
                    jumlahHabis.parentElement.classList.add('hidden');

                    // Tampilkan input yang sesuai dengan kondisi yang dipilih
                    if (kondisi === 'Hilang') {
                        jumlahHilang.parentElement.classList.remove('hidden');
                    } else if (kondisi === 'Rusak') {
                        jumlahRusak.parentElement.classList.remove('hidden');
                    } else if (kondisi === 'Habis') {
                        jumlahHabis.parentElement.classList.remove('hidden');
                    }
                }
            </script>
        </div>
    </div>
</div>
