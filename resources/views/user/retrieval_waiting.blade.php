<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Konfirmasi - Pengambilan Container</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')

    <div class="container-fluid flex justify-center items-center min-h-screen py-12">
        @include('components.retrieval_waiting_confirmation', [
            'container_number' => $container_number,
            'license_plate' => $license_plate,
            'created_at' => $created_at
        ])
    </div>
</body>
</html> 