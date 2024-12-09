@extends('layouts.auth')

@section('hero-section')
    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-6 text-3xl font-bold text-center text-green-500">Lupa Kata Sandi</h2>
        <p>Klik link di bawah ini untuk mereset kata sandi Anda:</p>
        <a href="{{ route('reset-password.index', ['token' => $token]) }}">Reset Password</a>
    </div>
@endsection
