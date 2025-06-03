<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT GATE INDONESIA - Delivery Rejected</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    <div class="rounded-full bg-red-100 p-3">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Delivery Ditolak</h2>
                
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Alasan Penolakan:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ $delivery->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-gray-700 mb-2">Detail Delivery:</h3>
                    <dl class="grid grid-cols-1 gap-3">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <dt class="text-gray-600">Nomor Container:</dt>
                            <dd class="font-medium text-gray-900">{{ $delivery->container_number }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <dt class="text-gray-600">Plat Nomor:</dt>
                            <dd class="font-medium text-gray-900">{{ $delivery->license_plate }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <dt class="text-gray-600">Jenis Muatan:</dt>
                            <dd class="font-medium text-gray-900">{{ $delivery->luggage }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <dt class="text-gray-600">Status Liquid:</dt>
                            <dd class="font-medium text-gray-900">{{ $delivery->liquid_status ? 'Ya' : 'Tidak' }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <dt class="text-gray-600">Status:</dt>
                            <dd class="font-medium text-red-600">Ditolak</dd>
                        </div>
                        <div class="flex justify-between py-2">
                            <dt class="text-gray-600">Tanggal Request:</dt>
                            <dd class="font-medium text-gray-900">{{ $delivery->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="flex justify-center">
                    <a href="{{ route('index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html> 