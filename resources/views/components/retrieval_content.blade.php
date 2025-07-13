<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- Tombol Cetak -->
            <div class="mb-6 flex justify-end">
                <button onclick="openRetrievalPrintModal()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
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
                        <p class="text-2xl font-bold" style="color: white !important;">{{ $retrievals->where('status', 'pending')->count() }}</p>
                        <p class="text-sm" style="color: white !important;">Pending Retrievals</p>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded-lg bg-sky-400 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" style="background: #38bdf8;">
                    <div class="text-center">
                        <p class="text-2xl font-bold" style="color: white !important;">{{ $retrievals->where('status', 'approved')->count() }}</p>
                        <p class="text-sm" style="color: white !important;">Approved Retrievals</p>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded-lg bg-sky-400 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" style="background: #38bdf8;">
                    <div class="text-center">
                        <p class="text-2xl font-bold" style="color: white !important;">{{ $retrievals->where('status', 'rejected')->count() }}</p>
                        <p class="text-sm" style="color: white !important;">Rejected Retrievals</p>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="w-full text-sm text-left rtl:text-right text-gray-700 bg-white">
                    <thead class="text-xs text-white uppercase bg-sky-400" style="background: #38bdf8;">
                        <tr>
                            <th scope="col" class="px-6 py-3">Container Number</th>
                            <th scope="col" class="px-6 py-3">Container Name</th>
                            <th scope="col" class="px-6 py-3">License Plate</th>
                            <th scope="col" class="px-6 py-3">Retrieval Date</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Notes</th>
                            <th scope="col" class="px-6 py-3">Request Date</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($retrievals as $retrieval)
                            <tr class="odd:bg-white even:bg-blue-50 border-b border-blue-200 hover:bg-blue-100 transition-colors duration-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $retrieval->container_number }}
                                </th>
                                <td class="px-6 py-4 text-gray-800">{{ $retrieval->container_name }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $retrieval->license_plate }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $retrieval->retrieval_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($retrieval->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($retrieval->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($retrieval->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-800">{{ $retrieval->notes ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $retrieval->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($retrieval->status === 'pending')
                                        <div class="flex space-x-2">
                                            <button onclick="approveRetrieval({{ $retrieval->id }})" class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-200 text-sm">Approve</button>
                                            <button onclick="openRejectModal('{{ $retrieval->id }}')" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200 text-sm">Reject</button>
                                        </div>
                                    @else
                                        <span class="text-gray-500">No actions available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-600">Tidak ada request pengambilan container</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $retrievals->links() }}
                </div>
            </div>
        </div>

<!-- Modal Print Retrieval -->
<div id="retrievalPrintModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pilih Periode Laporan Retrieval</h3>
            <form id="retrievalPrintForm">
                <div class="mb-4">
                    <label for="retrievalPrintMonth" class="block text-sm font-medium text-gray-700 mb-2">Bulan:</label>
                    <select id="retrievalPrintMonth" name="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
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
                    <label for="retrievalPrintYear" class="block text-sm font-medium text-gray-700 mb-2">Tahun:</label>
                    <select id="retrievalPrintYear" name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        @for($y = 2023; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRetrievalPrintModal()" class="px-4 py-2 text-gray-500 rounded-md hover:bg-gray-100 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="printRetrievalPDF()" class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600 transition-colors duration-200">
                        Cetak PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRetrievalPrintModal() {
        document.getElementById('retrievalPrintModal').classList.remove('hidden');
    }

    function closeRetrievalPrintModal() {
        document.getElementById('retrievalPrintModal').classList.add('hidden');
    }

    function printRetrievalPDF() {
        const month = document.getElementById('retrievalPrintMonth').value;
        const year = document.getElementById('retrievalPrintYear').value;
        
        let url = '{{ route("admin.retrieval.print") }}';
        const params = new URLSearchParams();
        
        if (month) params.append('month', month);
        if (year) params.append('year', year);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        // Buka dalam tab baru untuk download
        window.open(url, '_blank');
        closeRetrievalPrintModal();
    }
</script>