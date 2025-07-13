<div class="bg-white rounded-lg shadow-md p-6 w-96">
    <!-- Debug Info (temporary) -->
    <div class="text-xs text-gray-500 mb-4">
        Retrieval ID: {{ session('retrieval_data.id') }}
    </div>

    <!-- Waiting Icon -->
    <div class="flex items-center justify-center mb-4">
        <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center animate-pulse">
            <svg class="text-yellow-400 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Status Message -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Menunggu Konfirmasi</h2>
        <p class="text-gray-600 mt-2">Permintaan pengambilan container Anda sedang menunggu persetujuan admin</p>
    </div>

    <!-- Order Details -->
    <div class="bg-gray-100 p-4 rounded-lg space-y-2">
        <div class="flex justify-between">
            <strong class="text-gray-700">Nomor Peti Kemas:</strong>
            <span class="text-gray-800">{{ $container_number }}</span>
        </div>
        <div class="flex justify-between">
            <strong class="text-gray-700">Nama Peti Kemas:</strong>
            <span class="text-gray-800">{{ $container_name }}</span>
        </div>
        <div class="flex justify-between">
            <strong class="text-gray-700">Tanggal:</strong>
            <span class="text-gray-800">{{ $created_at }}</span>
        </div>
        <div class="flex justify-between">
            <strong class="text-gray-700">Nomor Plat Kendaraan:</strong>
            <span class="text-gray-800">{{ $license_plate }}</span>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="mt-6">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <div class="h-2 bg-blue-500 rounded"></div>
                <p class="text-sm text-gray-600 mt-1">Permintaan Dikirim</p>
            </div>
            <div class="flex-1">
                <div class="h-2 bg-yellow-400 rounded animate-pulse"></div>
                <p class="text-sm text-gray-600 mt-1">Menunggu Konfirmasi</p>
            </div>
            <div class="flex-1">
                <div class="h-2 bg-gray-300 rounded"></div>
                <p class="text-sm text-gray-600 mt-1">Disetujui</p>
            </div>
        </div>
    </div>

    <!-- Refresh Button -->
    <div class="mt-6 flex justify-center">
        <button onclick="checkRetrievalStatus()" class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span id="refresh-text">Refresh Status</span>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let retrievalId = '{{ session('retrieval_data.id') }}';
    console.log('Retrieval ID:', retrievalId); // Debug log
    
    let checkInterval;
    let isChecking = false;

    window.checkRetrievalStatus = async function() {
        if (isChecking) return;
        
        isChecking = true;
        const button = document.querySelector('#refresh-text');
        const originalText = button.textContent;
        button.textContent = 'Mengecek...';

        try {
            console.log('Checking status for retrieval:', retrievalId); // Debug log
            const response = await fetch(`/retrievals/${retrievalId}/check-status`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Status response:', data); // Debug log
            
            if (data.status === 'approved') {
                window.location.href = `/retrievals/${retrievalId}/ticket`;
            } else if (data.status === 'rejected') {
                window.location.href = `/retrievals/${retrievalId}/reject`;
            }
        } catch (error) {
            console.error('Error details:', error); // Detailed error log
            alert('Terjadi kesalahan saat mengecek status. Silakan coba lagi.');
        } finally {
            isChecking = false;
            button.textContent = originalText;
        }
    }

    // Check status setiap 10 detik
    checkInterval = setInterval(checkRetrievalStatus, 10000);

    // Hentikan polling saat user meninggalkan halaman
    window.addEventListener('beforeunload', () => {
        clearInterval(checkInterval);
    });
});
</script> 