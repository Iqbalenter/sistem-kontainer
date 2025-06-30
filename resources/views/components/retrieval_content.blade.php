<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
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
                                <td colspan="7" class="px-6 py-4 text-center text-gray-600">Tidak ada request pengambilan container</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $retrievals->links() }}
                </div>
            </div>
        </div>