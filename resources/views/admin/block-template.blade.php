@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Block {{ $block->name }}</h1>
        <div class="flex items-center space-x-4">
            <span class="px-4 py-2 bg-sky-400 text-white rounded-full font-medium shadow-sm" style="background-color: #38bdf8 !important; color: white !important;">
                {{ $block->current_capacity }}/{{ $block->max_capacity }} Container
            </span>
            <span class="px-4 py-2 {{ $block->current_type ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }} rounded-full font-medium shadow-sm">
                {{ $block->current_type ? ucfirst($block->current_type) : 'Kosong' }}
            </span>
        </div>
    </div>

    @if($containers->isEmpty())
        <div class="bg-sky-50 border border-sky-200 rounded-lg p-8 text-center">
            <p class="text-sky-600 text-lg font-medium">Tidak ada container di block ini</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-lg shadow-sm">
            <table class="min-w-full bg-white">
                <thead class="bg-sky-400" style="background-color: #38bdf8 !important;">
                    <tr>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">No.</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">Container Number</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">License Plate</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">Luggage</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">Liquid Status</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">User</th>
                        <th class="py-4 px-6 text-left font-semibold" style="color: white !important;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($containers as $index => $container)
                    <tr id="container-{{ $container->id }}" class="odd:bg-white even:bg-blue-50 hover:bg-blue-100 transition-colors duration-200 border-b border-gray-200">
                        <td class="py-4 px-6 text-gray-800 font-medium">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 text-gray-800">{{ $container->container_number }}</td>
                        <td class="py-4 px-6 text-gray-800">{{ $container->license_plate }}</td>
                        <td class="py-4 px-6 text-gray-800">{{ $container->luggage }}</td>
                        <td class="py-4 px-6">
                            <span class="px-3 py-1 {{ $container->liquid_status === 'liquid' ? 'bg-sky-400 text-white' : 'bg-green-500 text-white' }} rounded-full text-sm font-medium shadow-sm">
                                {{ ucfirst($container->liquid_status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-800">{{ $container->user->name }}</td>
                        <td class="py-4 px-6">
                            <button 
                                onclick="removeContainer('{{ $block->name }}', {{ $container->id }})"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all duration-200 transform hover:scale-105 shadow-sm font-medium">
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
            const capacitySpan = document.querySelector('.bg-sky-400');
            const typeSpan = document.querySelector('.bg-green-500, .bg-gray-400');
            
            if (data.block) {
                capacitySpan.textContent = `${data.block.current_capacity}/${data.block.max_capacity} Container`;
                typeSpan.textContent = data.block.current_type ? ucfirst(data.block.current_type) : 'Kosong';
                typeSpan.className = `px-4 py-2 ${data.block.current_type ? 'bg-green-500 text-white' : 'bg-gray-400 text-white'} rounded-full font-medium shadow-sm`;
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