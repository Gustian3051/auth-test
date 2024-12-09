@extends('layouts.auth')

@section('hero-section')
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-6 text-3xl font-bold text-center text-green-500">Lupa Kata Sandi</h2>

        <form action="{{ route('forgot-password.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Email">
                @error('email')
                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Kirim</button>
        </form>

        <!-- Forgot Password -->
        <p class="mt-4 text-sm text-center text-gray-600">
            <a href="{{ route('login.index') }}" class="text-green-500 hover:underline">Kembali ke halaman Login</a>
        </p>
    </div>
@endsection
