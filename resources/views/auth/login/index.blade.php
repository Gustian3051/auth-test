@extends('layouts.auth')

@section('hero-section')
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-6 text-3xl font-bold text-center text-green-500">Masuk</h2>

        <form action="" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf

            <!-- Email -->
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Username/NIM</label>
                <input type="text" id="name" name="identifier"
                    class="w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan Username/NIM">
            </div>

            <!-- Password -->
            <div class="relative ">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Kata Sandi</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Masukkan Password">
                <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 mt-7 mr-3">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>

            </div>
            <p class="mt-4 text-sm text-right text-gray-600">
                <a href="" class="text-green-500 hover:underline">Lupa kata sandi?</a>
            </p>
            <!-- Login Button -->
            <button type="submit"
                class="w-full px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Masuk</button>
        </form>
    </div>
@endsection
