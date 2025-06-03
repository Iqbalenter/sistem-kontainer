<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- First row - 3 columns -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $retrievals->where('status', 'pending')->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pending Retrievals</p>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $retrievals->where('status', 'approved')->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Approved Retrievals</p>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $retrievals->where('status', 'rejected')->count() }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rejected Retrievals</p>
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

                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $retrieval->container_number }}
                                </th>
                                <td class="px-6 py-4">{{ $retrieval->license_plate }}</td>
                                <td class="px-6 py-4">{{ $retrieval->retrieval_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($retrieval->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($retrieval->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($retrieval->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $retrieval->notes ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $retrieval->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($retrieval->status === 'pending')
                                        <div class="flex space-x-2">
                                            <button onclick="approveRetrieval({{ $retrieval->id }})" class="font-medium text-green-600 dark:text-green-500 hover:underline">Approve</button>
                                            <button onclick="openRejectModal('{{ $retrieval->id }}')" class="font-medium text-red-600 dark:text-red-500 hover:underline">Reject</button>
                                        </div>
                                    @else
                                        <span class="text-gray-400">No actions available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center">Tidak ada request pengambilan container</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $retrievals->links() }}
                </div>
            </div>
        </div>