<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Container - {{ $container_number }}</title>
    <link rel="icon" href="{{ asset('storage/pelindo-removebg-preview.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')

    <div class="container-fluid flex justify-center items-center min-h-screen py-12">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <!-- Success Header -->
            <div class="text-center mb-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="text-green-500 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Delivery Dikonfirmasi!</h2>
                <p class="text-gray-600 mt-1">Container telah ditempatkan di lokasi yang ditentukan</p>
            </div>

            <!-- QR Code -->
            <div class="flex justify-center mb-6">
                <div class="p-4 bg-gray-100 rounded-lg">
                    <svg class="h-32 w-32" viewBox="0 0 100 100">
                        <rect x="10" y="10" width="80" height="80" fill="none" stroke="currentColor" stroke-width="2"/>
                        <text x="50" y="50" text-anchor="middle" dominant-baseline="middle" class="text-xs">{{ $container_number }}</text>
                    </svg>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600">Nomor Peti Kemas</span>
                    <span class="font-semibold text-gray-800">{{ $container_number }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600">Tanggal</span>
                    <span class="font-semibold text-gray-800">{{ $created_at }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600">Nomor Plat Kendaraan</span>
                    <span class="font-semibold text-gray-800">{{ $license_plate }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600">Muatan</span>
                    <span class="font-semibold text-gray-800">{{ $luggage }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600">Tipe Muatan</span>
                    <span class="font-semibold text-gray-800">{{ ucfirst($liquid_status) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Lokasi Block</span>
                    <span class="font-bold text-blue-600 text-lg">{{ $block }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-3">
                <button onclick="window.print()" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Ticket
                </button>
                <button onclick="goToDashboard()" class="block w-full text-center bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-200">
                    Kembali ke Dashboard
                </button>
            </div>

            <!-- Print Styles -->
            <style>
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    .bg-white {
                        background-color: white !important;
                        padding: 20px !important;
                    }
                    .bg-white, .bg-white * {
                        visibility: visible;
                    }
                    .bg-white {
                        position: absolute;
                        left: 0;
                        top: 0;
                    }
                    button, a {
                        display: none !important;
                    }
                }
            </style>
        </div>
    </div>

    <script>
        // Fungsi untuk kembali ke dashboard
        function goToDashboard() {
            window.location.href = '{{ route('index') }}';
        }

        // Mencegah kembali ke halaman sebelumnya
        window.history.pushState(null, '', window.location.href);
        window.onpopstate = function() {
            window.location.href = '{{ route('index') }}';
        };
    </script>
</body>
</html> 