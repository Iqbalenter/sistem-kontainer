@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Block {{ $block->name }}</h1>
        <div class="flex items-center space-x-4">
            <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full">
                {{ $block->current_capacity }}/{{ $block->max_capacity }} Container
            </span>
            <span class="px-4 py-2 {{ $block->current_type ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full">
                {{ $block->current_type ? ucfirst($block->current_type) : 'Kosong' }}
            </span>
        </div>
    </div>

    @if($containers->isEmpty())
        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <p class="text-gray-500 text-lg">Tidak ada container di block ini</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">No.</th>
                        <th class="py-3 px-4 text-left">Container Number</th>
                        <th class="py-3 px-4 text-left">License Plate</th>
                        <th class="py-3 px-4 text-left">Luggage</th>
                        <th class="py-3 px-4 text-left">Liquid Status</th>
                        <th class="py-3 px-4 text-left">User</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($containers as $index => $container)
                    <tr id="container-{{ $container->id }}">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">{{ $container->container_number }}</td>
                        <td class="py-3 px-4">{{ $container->license_plate }}</td>
                        <td class="py-3 px-4">{{ $container->luggage }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 {{ $container->liquid_status === 'liquid' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }} rounded-full text-sm">
                                {{ ucfirst($container->liquid_status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $container->user->name }}</td>
                        <td class="py-3 px-4">
                            <button 
                                onclick="removeContainer('{{ $block->name }}', {{ $container->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
<script>
function removeContainer(blockName, deliveryId) {
    if (!confirm('Apakah Anda yakin ingin menghapus container ini dari block?')) {
        return;
    }

    fetch(`/admin/blocks/${blockName}/containers/${deliveryId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            // Hapus baris container dari tabel
            document.getElementById(`container-${deliveryId}`).remove();
            
            // Update informasi block
            const capacitySpan = document.querySelector('.bg-blue-100');
            const typeSpan = document.querySelector('.bg-green-100, .bg-gray-100');
            
            if (data.block) {
                capacitySpan.textContent = `${data.block.current_capacity}/${data.block.max_capacity} Container`;
                typeSpan.textContent = data.block.current_type ? ucfirst(data.block.current_type) : 'Kosong';
                typeSpan.className = `px-4 py-2 ${data.block.current_type ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} rounded-full`;
            }
            
            // Jika tidak ada container lagi, tampilkan pesan kosong
            const tbody = document.querySelector('tbody');
            if (!tbody || tbody.children.length === 0) {
                location.reload();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus container');
    });
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
@endpush
@endsection 