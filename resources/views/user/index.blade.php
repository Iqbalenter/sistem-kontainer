<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT GATE INDONESIA - Dashboard</title>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.navbar')
    
    <div class="container-fluid flex justify-center items-center min-h-screen py-12">
        <div class="w-full max-w-md" x-data="{ activeForm: 'delivery' }">
            <!-- Toggle Buttons -->
            <div class="flex justify-center mb-6">
                <button 
                    @click="activeForm = 'delivery'" 
                    :class="{ 'bg-blue-600 text-white': activeForm === 'delivery', 'bg-gray-200 text-gray-700': activeForm !== 'delivery' }"
                    class="px-6 py-3 rounded-l-lg font-semibold transition duration-200">
                    Delivery
                </button>
                <button 
                    @click="activeForm = 'retrieval'"
                    :class="{ 'bg-blue-600 text-white': activeForm === 'retrieval', 'bg-gray-200 text-gray-700': activeForm !== 'retrieval' }"
                    class="px-6 py-3 rounded-r-lg font-semibold transition duration-200">
                    Retrieval
                </button>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Delivery Form -->
                <div x-show="activeForm === 'delivery'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('components.delivery_form')
                </div>
                
                <!-- Retrieval Form -->
                <div x-show="activeForm === 'retrieval'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @include('components.retrieval_form')
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>
</html>