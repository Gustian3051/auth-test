<div id="detail{{ $data->id }}" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Peminjaman
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="grid grid-cols-2 gap-2">
                    <div class="flex justify-center items-center gap-2">
                        <!-- Verifikasi Status -->
                        <form action="{{ route('staff.updateStatus', $data->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <select name="status" class="border rounded">
                                <option value="Diproses" @if ($data->status == 'Diproses') selected @endif>
                                    Diproses</option>
                                <option value="Diterima" @if ($data->status == 'Diterima') selected @endif>
                                    Diterima</option>
                                <option value="Ditolak" @if ($data->status == 'Ditolak') selected @endif>
                                    Ditolak</option>
                            </select>
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Update</button>
                        </form>
                    </div>
                    <div class="flex justify-center items-center gap-2">
                        <!-- Verifikasi Peminjaman -->
                        <form action="{{ route('staff.updatePersetujuan', $data->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <select name="persetujuan" class="border rounded">
                                <option value="Belum Diserahkan"
                                    {{ old('persetujuan', $data->persetujuan) == 'Belum Diserahkan' ? 'selected' : '' }}>
                                    Belum Diserahkan
                                </option>
                                <option value="Diserahkan"
                                    {{ old('persetujuan', $data->persetujuan) == 'Diserahkan' ? 'selected' : '' }}>
                                    Diserahkan
                                </option>
                            </select>
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Update</button>
                        </form>

                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
