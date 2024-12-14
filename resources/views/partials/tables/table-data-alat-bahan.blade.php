<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-barang">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Alat & Bahan
                </th>
                <th scope="col" class="px-6 py-3">
                    Kategori
                </th>
                <th scope="col" class="px-6 py-3">
                    Stok
                </th>
                <th scope="col" class="px-6 py-3">
                    Satuan
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($dataAlatBahan->isEmpty())
                <tr>
                    <td colspan="6" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada data Alat & Bahan
                    </td>
                </tr>
            @else
                @foreach ($dataAlatBahan as $data)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->kategori->kategori }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->stok->stok }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->satuan->satuan }}
                        </td>
                        <td scope="col" class="flex items-center gap-2 px-6 py-3 justify-center">
                            <div>
                                <button type="button" data-modal-target="detail{{ $data->id }}"
                                    data-modal-toggle="detail{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-yellow-400 rounded">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            <div>
                                <form id="delete-form-{{ $data->id }}"
                                    action="{{ route('barang.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $data->id }})"
                                        class="flex items-center px-2 py-2 text-sm text-white bg-red-500 rounded">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div>
                                <button type="button" data-modal-target="edit{{ $data->id }}"
                                    data-modal-toggle="edit{{ $data->id }}"
                                    class="flex items-center px-2 py-2 text-sm text-white bg-blue-500 rounded">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @include('partials.modals.detail.modal-alat-bahan', [
                        'dataAlatBahan' => $dataAlatBahan,
                        'dataKategori' => $dataKategori,
                        'dataSatuan' => $dataSatuan,
                    ])
                    @include('partials.modals.edit.modal-alat-bahan', [
                        'dataAlatBahan' => $dataAlatBahan,
                        'dataKategori' => $dataKategori,
                        'dataSatuan' => $dataSatuan,
                    ])
                @endforeach
            @endif

        </tbody>
    </table>
</div>
