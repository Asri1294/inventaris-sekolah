<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    @php
        $badge = [
            'diajukan' => 'bg-yellow-100 text-yellow-800',
            'dipinjam' => 'bg-blue-100 text-blue-800',
            'dikembalikan' => 'bg-green-100 text-green-800',
            'terlambat' => 'bg-red-100 text-red-800',
            'ditolak' => 'bg-gray-100 text-gray-800',
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div class="relative bg-white shadow-sm border border-gray-200 border-l-4 border-l-sky-500 rounded-lg p-6">
                    <div class="absolute top-4 right-4 text-sky-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['borrowed'], 0, ',', '.') }}</p>
                </div>

                <div class="relative bg-white shadow-sm border border-gray-200 border-l-4 border-l-red-500 rounded-lg p-6">
                    <div class="absolute top-4 right-4 text-red-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Terlambat</p>
                    <p class="mt-2 text-3xl font-semibold text-red-600">{{ number_format($stats['overdue'], 0, ',', '.') }}</p>
                </div>

                <div class="relative bg-white shadow-sm border border-gray-200 border-l-4 border-l-amber-500 rounded-lg p-6">
                    <div class="absolute top-4 right-4 text-amber-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-600">{{ number_format($stats['pending'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-x-auto">
                <div class="flex items-center justify-between px-4 py-3">
                    <h3 class="font-semibold text-gray-800">Peminjaman Terbaru</h3>
                    <a href="{{ route('my-loans.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Lihat semua
                    </a>
                </div>

                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Jatuh Tempo</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentLoans as $loan)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $loan->item->name }}</td>
                                <td class="px-4 py-3">{{ number_format($loan->quantity, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $loan->due_date->locale('id')->translatedFormat('j M Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2 py-1 text-xs font-medium {{ $badge[$loan->status] ?? '' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>