<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Container - {{ $container_number }}</title>
    <link rel="icon" href="{{ asset('storage/pelindo-removebg-preview.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @include('components.navbar')

    <div class="container-fluid flex justify-center items-center min-h-screen py-12">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl mx-4" style="width: 800px;">
            <!-- Header dengan Logo -->
            <div class="bg-white px-8 py-6 text-gray-900 relative overflow-hidden shadow-lg">
                <div class="relative z-10 flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('storage/pelindo-removebg-preview.png') }}" alt="PELINDO Logo" class="h-16 w-auto mr-6">
                        <div>
                            <h1 class="text-2xl font-bold mb-1 text-gray-900">DELIVERY CONFIRMATION</h1>
                            <p class="text-gray-600 text-sm">PT PELABUHAN INDONESIA</p>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="text-white h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-green-600 font-medium text-lg">BERHASIL DIKONFIRMASI</span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-8 py-6">
                <!-- Ticket ID -->
                <div class="text-center mb-6">
                    <div class="inline-block bg-blue-50 px-6 py-3 rounded-full border border-blue-200">
                        <span class="text-blue-800 font-mono text-lg font-bold">{{ $container_number }}</span>
                    </div>
                </div>

                <!-- Details Grid - Horizontal Layout -->
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Container</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $container_number }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Block</p>
                        <p class="font-bold text-blue-600 text-lg">{{ $block }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Kendaraan</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $license_plate }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Muatan</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $luggage }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Tipe</p>
                        <p class="font-bold text-gray-900 text-lg">{{ ucfirst($liquid_status) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">Tanggal</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $created_at }}</p>
                    </div>
                </div>

                <!-- Warning/Info -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-amber-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <p class="text-amber-800 text-sm font-medium">PENTING</p>
                            <p class="text-amber-700 text-sm mt-1">Tunjukkan tiket ini kepada petugas untuk mengakses area container</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button onclick="window.print()" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 px-6 rounded-xl hover:from-blue-700 hover:to-blue-800 transition duration-200 flex items-center justify-center font-medium shadow-lg">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Tiket
                    </button>
                    <button onclick="goToDashboard()" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition duration-200 font-medium">
                        Kembali ke Dashboard
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t">
                <p class="text-center text-sm text-gray-500">
                    © {{ date('Y') }} PT Pelabuhan Indonesia - Sistem Manajemen Kontainer
                </p>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body {
                background: white !important;
            }
            body * {
                visibility: hidden;
            }
            .container-fluid {
                visibility: visible !important;
            }
            .container-fluid * {
                visibility: visible !important;
            }
            .rounded-2xl {
                background-color: white !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                max-width: none !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 20px !important;
                position: absolute;
                left: 0;
                top: 0;
            }
            button, .hidden-print {
                display: none !important;
            }
            .bg-white {
                background: white !important;
            }
            .bg-gradient-to-r {
                background: #2563eb !important;
            }
            .bg-gray-50 {
                background: #f9fafb !important;
            }
            .bg-amber-50 {
                background: #fffbeb !important;
            }
            .text-gray-900 {
                color: black !important;
            }
            .bg-blue-50 {
                background: #eff6ff !important;
            }
            .shadow-lg {
                box-shadow: none !important;
            }
        }
    </style>

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