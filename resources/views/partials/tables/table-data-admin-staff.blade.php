<div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="100%"
        id="data-barang">
        <thead class=" text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    No
                </th>
                <th scope="col" class="px-6 py-3">
                    Nama Admin/Staff
                </th>
                <th scope="col" class="px-6 py-3">
                    NIDN/NIP
                </th>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($dataAdminStaff->isEmpty())
                <tr>
                    <td colspan="9" class="px-6 py-3 text-center text-gray-500 border">
                        Tidak ada data Admin/Staff
                    </td>
                </tr>
            @else
                @foreach ($dataAdminStaff as $data)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td scope="col" class="px-6 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->nama }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->nidn }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->username }}
                        </td>
                        <td scope="col" class="px-6 py-3">
                            {{ $data->roles[0]->name }}
                        </td>
                        <td scope="col" class="flex items-center gap-2 px-6 py-3 justify-center">
                            <div>
                                <form id="delete-form-{{ $data->id }}"
                                    action="{{ route('admin-staff.destroy', $data->id) }}" method="POST">
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

                    @include('partials.modals.edit.modal-admin-staff', [
                        'dataAdminStaff' => $dataAdminStaff,
                    ])
                @endforeach
            @endif

        </tbody>
    </table>
</div>
