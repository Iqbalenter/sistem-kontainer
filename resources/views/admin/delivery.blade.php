<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PELINDO - Delivery</title>
    <link rel="icon" href="{{ asset('storage/pelindo-removebg-preview.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    @vite([])
</head>
<body>
    @include('components.admin_side')
    
    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <x-delivery_content :deliveries="$deliveries" />
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @stack('scripts')
    
    <script>
        // Tampilkan pesan error jika ada
        @if(session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
</body>
</html> 