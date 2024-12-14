<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Informasi Peminjaman
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
                @foreach ($data->peminjamanDetail as $detail)
                    <div class="max-w-screen-xl mx-auto">
                        <div
                            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow p-3 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset($detail->foto ?? 'image/barang.png') }}" class="w-12"
                                            alt="ini gambar">
                                        <p class="text-sm ms-2">{{ $detail->alatBahan->nama }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-center items-center text-center">
                                    <div class="px-4">
                                        <p class="text-sm text-gray-900">
                                            Jumlah :
                                            <span>
                                            {{ $detail->jumlah }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-900">
                                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                            {{ $detail->alatBahan->kategori->kategori }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
