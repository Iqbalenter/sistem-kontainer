<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Waktu</th>
                <th scope="col" class="px-6 py-3">Pengguna</th>
                <th scope="col" class="px-6 py-3">Aktivitas</th>
                <th scope="col" class="px-6 py-3">Deskripsi</th>
                <th scope="col" class="px-6 py-3">Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                    <td class="px-6 py-4">{{ $log->causer ? $log->causer->name : 'System' }}</td>
                    <td class="px-6 py-4">{{ ucfirst($log->event) }}</td>
                    <td class="px-6 py-4">{{ $log->description }}</td>
                    <td class="px-6 py-4">
                        <button data-modal-target="detailModal-{{ $log->id }}" data-modal-toggle="detailModal-{{ $log->id }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Lihat Detail
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div id="detailModal-{{ $log->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Detail Aktivitas
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detailModal-{{ $log->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Waktu:</strong><br>
                                            {{ $log->created_at->format('d M Y H:i:s') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Pengguna:</strong><br>
                                            {{ $log->causer ? $log->causer->name : 'System' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Tipe:</strong><br>
                                            {{ $log->log_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Aksi:</strong><br>
                                            {{ ucfirst($log->event) }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                        <strong>Deskripsi:</strong><br>
                                        {{ $log->description }}
                                    </p>
                                </div>
                                @if($log->properties)
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                            <strong>Properties:</strong><br>
                                            <pre class="mt-2 p-2 bg-gray-100 dark:bg-gray-800 rounded">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada aktivitas yang tercatat</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div> 