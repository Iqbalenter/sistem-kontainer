<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PELINDO - Retrieval</title>
    <link rel="icon" href="{{ asset('storage/pelindo-removebg-preview.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.admin_side')

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        @include('components.retrieval_content')
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Alasan Penolakan</h3>
                <form id="rejectForm" onsubmit="handleReject(event)">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="retrievalId" id="retrievalId">
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

    <script>
        function approveRetrieval(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui permintaan pengambilan ini?')) {
                fetch(`/retrievals/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'approved'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message || 'Terjadi kesalahan saat menyetujui permintaan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyetujui permintaan pengambilan');
                });
            }
        }

        function handleReject(event) {
            event.preventDefault();
            
            const retrievalId = document.getElementById('retrievalId').value;
            const notes = document.querySelector('textarea[name="notes"]').value;

            fetch(`/retrievals/${retrievalId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: 'rejected',
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menolak permintaan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menolak permintaan pengambilan');
            })
            .finally(() => {
                closeRejectModal();
            });
        }

        function openRejectModal(retrievalId) {
            const modal = document.getElementById('rejectModal');
            document.getElementById('retrievalId').value = retrievalId;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            document.getElementById('rejectForm').reset();
            modal.classList.add('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html> 