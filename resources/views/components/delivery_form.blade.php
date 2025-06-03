<!-- Debug Info -->
@if(auth()->check())
    <div class="mb-4 p-4 bg-green-100 rounded-lg">
        <p class="text-green-800">Logged in as: {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
    </div>
@else
    <div class="mb-4 p-4 bg-red-100 rounded-lg">
        <p class="text-red-800">Not logged in</p>
    </div>
@endif

<!-- Delivery Form -->
<div class="w-full mx-auto">
    <form action="{{ route('delivery.store') }}" method="POST" class="w-full mx-auto" id="deliveryForm">
        @csrf
        <div class="mb-5">
            <label for="container_number" class="block mb-2 text-sm font-medium text-gray-900">No Peti Kemas</label>
            <input type="text" id="container_number" name="container_number" value="{{ old('container_number') }}" placeholder="No Peti Kemas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('container_number') border-red-500 @enderror" required>
            @error('container_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="license_plate" class="block mb-2 text-sm font-medium text-gray-900">Nomor Plat Kendaraan</label>
            <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" placeholder="Nomor Plat Kendaraan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('license_plate') border-red-500 @enderror" required>
            @error('license_plate')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="luggage" class="block mb-2 text-sm font-medium text-gray-900">Nama Peti Kemas</label>
            <input type="text" id="luggage" name="luggage" value="{{ old('luggage') }}" placeholder="TANTO, MAERSK" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('luggage') border-red-500 @enderror" required>
            @error('luggage')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="liquid_status" class="block mb-2 text-sm font-medium text-gray-900">Tipe Muatan</label>
            <select id="liquid_status" name="liquid_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('liquid_status') border-red-500 @enderror" required>
                <option value="">Pilih Tipe Muatan</option>
                <option value="cair" {{ old('liquid_status') == 'cair' ? 'selected' : '' }}>Cair</option>
                <option value="non-cair" {{ old('liquid_status') == 'non-cair' ? 'selected' : '' }}>Non-Cair</option>
            </select>
            @error('liquid_status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-center">
            <button type="submit" id="submitBtn" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Submit Delivery
            </button>
        </div>
    </form>

    @if (session('error'))
        <div class="mt-4 p-4 bg-red-100 rounded-lg">
            <p class="text-red-600">{{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-4 p-4 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<script>
document.getElementById('deliveryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Mengirim...';
    submitBtn.disabled = true;

    // Log form data untuk debugging
    const formData = new FormData(this);
    console.log('Submitting form data:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Submit form menggunakan fetch
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response;
    })
    .then(response => {
        // Handle both JSON and redirect responses
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => {
                if (data.error) {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
                return data;
            });
        } else {
            window.location.href = response.url;
            return null;
        }
    })
    .then(data => {
        if (data && data.redirect) {
            window.location.href = data.redirect;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});
</script>
