<!-- First row - 3 columns -->
<div class="grid grid-cols-3 gap-4 mb-4">
    <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $deliveries->where('status', 'pending')->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending Deliveries</p>
        </div>
    </div>
    <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $deliveries->where('status', 'confirmed')->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Confirmed Deliveries</p>
        </div>
    </div>
    <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
        <div class="text-center">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $deliveries->where('status', 'rejected')->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Rejected Deliveries</p>
        </div>
    </div>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $delivery->container_number }}
                </th>
                <td class="px-6 py-4">{{ $delivery->license_plate }}</td>
                <td class="px-6 py-4">{{ $delivery->luggage }}</td>
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
                        <span class="text-gray-400">Not Assigned</span>
                    @endif
                </td>
                <td class="px-6 py-4">{{ $delivery->user->name }}</td>
                <td class="px-6 py-4">
                    @if($delivery->status === 'pending')
                    <div class="flex space-x-2">
                        <button onclick="confirmDelivery({{ $delivery->id }})" class="font-medium text-green-600 dark:text-green-500 hover:underline">Confirm</button>
                        <button onclick="openRejectModal({{ $delivery->id }})" class="font-medium text-red-600 dark:text-red-500 hover:underline">Reject</button>
                    </div>
                    @else
                    <span class="text-gray-400">No actions available</span>
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
                    <button type="button" onclick="closeRejectModal()" class="mr-2 px-4 py-2 text-gray-500 rounded-md hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
