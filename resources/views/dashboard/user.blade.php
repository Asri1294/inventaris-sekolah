<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['borrowed'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Terlambat</p>
                    <p class="mt-2 text-3xl font-semibold text-red-600">{{ number_format($stats['overdue'], 0, ',', '.') }}</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-600">{{ number_format($stats['pending'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
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
                                <td class="px-4 py-3">{{ ucfirst($loan->status) }}</td>
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