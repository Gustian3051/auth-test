@extends('layouts.pengguna')

@section('content')
    @include('partials.navbar.pengguna-navbar')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: "#3085d6",
            });
        </script>
    @endif

    <div class="p-4 space-y-3">
        <div
            class="max-w-screen-xl mx-auto mt-14 bg-white p-4 text-green-500 rounded-xl text-2xl font-semibold text-center shadow-lg">
            Keranjang
        </div>

        <br>

        <div class="max-w-screen-xl p-4 mx-auto mt-14 bg-white rounded-xl shadow-lg">
            @if (empty($dataKeranjang))
                <div class="flex justify-center items-center text-center text-red-500 font-semibold">
                    <p>Keranjang Anda kosong, tambahkan barang terlebih dahulu sebelum melanjutkan.</p>
                </div>
            @else
                @foreach ($dataKeranjang as $data)
                    <div class="max-w-screen-xl p-1 mx-auto">
                        <div
                            class="w-full text-center bg-white border border-gray-200 rounded-lg shadow p-2 dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex items-center gap-2">
                                        @if (!empty($data->alatBahan))
                                            <!-- Tampilkan Barang -->
                                            <img src="{{ asset($data->foto ?? 'image/barang.png') }}" class="w-12"
                                                alt="{{ $data->foto }}">
                                            <p class="text-sm">{{ $data->nama }}</p>
                                            {{-- @elseif (!empty($data->ruangan))
                                            <!-- Tampilkan Ruangan -->
                                            <img src="{{ asset($data->ruangan->foto ?? 'image/barang.png') }}"
                                                class="w-12" alt="{{ $data->ruangan->foto }}">
                                            <p class="text-sm">{{ $data->ruangan->nama_ruangan }}</p> --}}
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-center items-center text-center">
                                    <div class="px-4">
                                        <p class="text-sm text-gray-900">{{ $data->jumlah }}</p>
                                    </div>
                                    <div class="px-4">
                                        <form action="{{ route('keranjang.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr class="my-5" />
                <button data-modal-target="form-peminjaman" data-modal-toggle="form-peminjaman"
                    class="px-4 py-2 w-full text-white bg-green-500 rounded-lg hover:bg-green-800" type="button">Form Peminjaman
                </button>

                @include('partials.modals.tambah.modal-peminjaman')






            @endif
        </div>
    </div>
@endsection
