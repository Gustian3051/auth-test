<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('image/logo/polindra.png') }}" type="image/x-icon">
    <title>SILK &mdash; Login</title>
    <style>
        .background {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('image/gedungGSC.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(3px);
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="flex flex-col items-center justify-center h-screen p-4 space-y-4 background">
        <div class="flex justify-center">
            <img src="{{ asset('image/logo/polindra.png') }}" alt="" class="object-cover w-full h-24">
        </div>
        @yield('hero-section')
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', () => {
                // Toggle tipe input
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.replace('text-gray-500', 'text-green-500'); // Ganti warna ikon
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.replace('text-green-500', 'text-gray-500'); // Kembalikan warna ikon
                }
            });
        });
    </script>
</body>

</html>
