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

                        <x-primary-button>Cari</x-primary-button>
                        @if (request('search') || request('action'))
                            <a href="{{ route('activity-logs.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
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
                                        {{ $log->created_at->timezone('Asia/Makassar')->format('d-m-Y H:i') }}
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
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>