<!-- Tombol Cetak -->
<div class="mb-6 flex justify-end">
    <button onclick="openPrintModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
        </svg>
        Cetak PDF
    </button>
</div>

<!-- First row - 3 columns -->
<div class="grid grid-cols-3 gap-4 mb-4">
    <div class="flex items-center justify-center h-24 rounded-lg bg-sky-400 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" style="background: #38bdf8;">
        <div class="text-center">
            <p class="text-2xl font-bold" style="color: white !important;">{{ $deliveries->where('status', 'pending')->count() }}</p>
            <p class="text-sm" style="color: white !important;">Pending Deliveries</p>
        </div>
    </div>
    <div class="flex items-center justify-center h-24 rounded-lg bg-sky-400 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" style="background: #38bdf8;">
        <div class="text-center">
            <p class="text-2xl font-bold" style="color: white !important;">{{ $deliveries->where('status', 'confirmed')->count() }}</p>
            <p class="text-sm" style="color: white !important;">Confirmed Deliveries</p>
        </div>
    </div>
    <div class="flex items-center justify-center h-24 rounded-lg bg-sky-400 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" style="background: #38bdf8;">
        <div class="text-center">
            <p class="text-2xl font-bold" style="color: white !important;">{{ $deliveries->where('status', 'rejected')->count() }}</p>
            <p class="text-sm" style="color: white !important;">Rejected Deliveries</p>
        </div>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-700 bg-white">
        <thead class="text-xs text-white uppercase bg-sky-400" style="background: #38bdf8;">
            <tr>
                <th scope="col" class="px-6 py-3">Container Number</th>
                <th scope="col" class="px-6 py-3">License Plate</th>
                <th scope="col" class="px-6 py-3">Luggage</th>
                <th scope="col" class="px-6 py-3">Liquid Status</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Block</th>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deliveries as $delivery)
            <tr class="odd:bg-white even:bg-blue-50 border-b border-blue-200 hover:bg-blue-100 transition-colors duration-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $delivery->container_number }}
                </th>
                <td class="px-6 py-4 text-gray-800">{{ $delivery->license_plate }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $delivery->luggage }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-medium {{ $delivery->liquid_status === 'liquid' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($delivery->liquid_status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        @if($delivery->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($delivery->status === 'confirmed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($delivery->status) }}
                    </span>
                </td>
                <td class="px-7 py-4">
                    @if($delivery->assigned_block)
                        <span class="px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            Block {{ $delivery->assigned_block->name }}
                        </span>
                    @else
                        <span class="text-gray-500">Not Assigned</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-800">{{ $delivery->user->name }}</td>
                <td class="px-6 py-4">
                    @if($delivery->status === 'pending')
                    <div class="flex space-x-2">
                        <button onclick="confirmDelivery({{ $delivery->id }})" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-200 text-sm">Confirm</button>
                        <button onclick="openRejectModal({{ $delivery->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200 text-sm">Reject</button>
                    </div>
                    @else
                    <span class="text-gray-500">No actions available</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Alasan Penolakan</h3>
            <form id="rejectForm" onsubmit="handleReject(event)">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="deliveryId" id="deliveryId">
                <div class="mt-2">
                    <textarea name="notes" rows="4" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" required></textarea>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closeRejectModal()" class="mr-2 px-4 py-2 text-gray-500 rounded-md hover:bg-gray-100 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors duration-200">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Print -->
<div id="printModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pilih Periode Laporan Delivery</h3>
            <form id="printForm">
                <div class="mb-4">
                    <label for="printMonth" class="block text-sm font-medium text-gray-700 mb-2">Bulan:</label>
                    <select id="printMonth" name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="printYear" class="block text-sm font-medium text-gray-700 mb-2">Tahun:</label>
                    <select id="printYear" name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @for($y = 2023; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closePrintModal()" class="px-4 py-2 text-gray-500 rounded-md hover:bg-gray-100 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="printDeliveryPDF()" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors duration-200">
                        Cetak PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openPrintModal() {
        document.getElementById('printModal').classList.remove('hidden');
    }

    function closePrintModal() {
        document.getElementById('printModal').classList.add('hidden');
    }

    function printDeliveryPDF() {
        const month = document.getElementById('printMonth').value;
        const year = document.getElementById('printYear').value;
        
        let url = '{{ route("admin.delivery.print") }}';
        const params = new URLSearchParams();
        
        if (month) params.append('month', month);
        if (year) params.append('year', year);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        // Buka dalam tab baru untuk download
        window.open(url, '_blank');
        closePrintModal();
    }

    function confirmDelivery(id) {
        if (confirm('Are you sure you want to confirm this delivery?')) {
            fetch(`/delivery/${id}/confirm`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.message);
                } else {
                    alert(data.message);
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while confirming the delivery');
            });
        }
    }

    function openRejectModal(id) {
        const modal = document.getElementById('rejectModal');
        document.getElementById('deliveryId').value = id;
        modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        document.getElementById('rejectForm').reset();
        modal.classList.add('hidden');
    }

    function handleReject(event) {
        event.preventDefault();
        
        const deliveryId = document.getElementById('deliveryId').value;
        const notes = document.querySelector('textarea[name="notes"]').value;

        fetch(`/delivery/${deliveryId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menolak delivery');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menolak delivery');
        })
        .finally(() => {
            closeRejectModal();
        });
    }

    // Update tombol reject untuk membuka modal
    document.querySelectorAll('[onclick^="rejectDelivery"]').forEach(button => {
        const id = button.getAttribute('onclick').match(/\d+/)[0];
        button.setAttribute('onclick', `openRejectModal(${id})`);
    });
</script>
@endpush
