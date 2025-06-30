<div class="relative overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="w-full text-sm text-left text-gray-700 bg-white">
        <thead class="text-xs text-white uppercase bg-sky-400" style="background: #38bdf8;">
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
                <tr class="odd:bg-white even:bg-blue-50 border-b border-blue-200 hover:bg-blue-100 transition-colors duration-200">
                    <td class="px-6 py-4 text-gray-800">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ $log->causer ? $log->causer->name : 'System' }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ ucfirst($log->event) }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ $log->description }}</td>
                    <td class="px-6 py-4">
                        <button data-modal-target="detailModal-{{ $log->id }}" data-modal-toggle="detailModal-{{ $log->id }}" class="px-3 py-1 bg-sky-400 text-white rounded-md hover:bg-sky-500 transition-colors duration-200 text-sm" style="background: #38bdf8;">
                            Lihat Detail
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div id="detailModal-{{ $log->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="flex items-start justify-between p-4 border-b rounded-t border-blue-200 bg-sky-50">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Detail Aktivitas
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center transition-colors duration-200" data-modal-hide="detailModal-{{ $log->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-700">
                                            <strong>Waktu:</strong><br>
                                            {{ $log->created_at->format('d M Y H:i:s') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-700">
                                            <strong>Pengguna:</strong><br>
                                            {{ $log->causer ? $log->causer->name : 'System' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-700">
                                            <strong>Tipe:</strong><br>
                                            {{ $log->log_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-700">
                                            <strong>Aksi:</strong><br>
                                            {{ ucfirst($log->event) }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-base leading-relaxed text-gray-700">
                                        <strong>Deskripsi:</strong><br>
                                        {{ $log->description }}
                                    </p>
                                </div>
                                @if($log->properties)
                                    <div>
                                        <p class="text-base leading-relaxed text-gray-700">
                                            <strong>Properties:</strong><br>
                                            <pre class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded">{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr class="bg-white border-b border-blue-200">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-600">Tidak ada aktivitas yang tercatat</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div> 