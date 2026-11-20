<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Log Aktivitas' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Log Aktivitas</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('activity-logs.index') }}"
                    class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari pengguna atau deskripsi..."
                            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                        <select name="action"
                            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Aksi</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" @selected(request('action') === $action)>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-gray-800 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                            </svg>
                            
                        </button>
                        @if (request('search') || request('action'))
                            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                
                            </a>
                        @endif
                    </div>

                    <x-per-page-select />
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Waktu</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Pengguna</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Aksi</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($logs as $log)
                                <tr>
                                    <td class="px-4 py-2">{{ $logs->firstItem() + $loop->index }}</td>
                                    <td class="whitespace-nowrap px-4 py-2">
                                        {{ $log->created_at->timezone('Asia/Makassar')->locale('id')->translatedFormat('j M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-2">{{ $log->user?->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-800">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ $log->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada catatan aktivitas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $logs->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>