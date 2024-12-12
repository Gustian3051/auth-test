{{-- resources/views/keranjang/index.blade.php --}}
@extends('layouts.pengguna')

@section('content')
    @include('partials.navbar.pengguna-navbar')

    <div class="space-y-3 p-4 mt-5">
        <div class="max-w-screen-xl p-6 mx-auto mt-14 bg-white rounded-xl">
            <h3 class="text-2xl font-semibold">Keranjang Pinjaman</h3>

            @if($keranjang->isEmpty())
                <p class="text-gray-500">Keranjang Anda kosong.</p>
            @else
                <table class="w-full table-auto mt-5">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Nama Barang</th>
                            <th class="px-4 py-2">Jumlah Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->alatBahan->nama }}</td>
                                <td class="px-4 py-2">{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
