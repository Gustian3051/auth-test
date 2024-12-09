@component('mail::message')
    # Password Berhasil Direset

    Halo {{ $mahasiswa->nama }},

    Anda berhasil melakukan reset password pada Akun anda. Berikut ini adalah password baru anda :

    Username: {{ $mahasiswa->nim }}
    Password: {{ $defaultPassword }}

    Terima kasih,
    {{ config('app.name') }}
@endcomponent
