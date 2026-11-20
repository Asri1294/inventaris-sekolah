<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Jumlah Barang</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['items'], 0, ',', '.') }}</p>
                </div>

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
        </div>
    </div>
</x-app-layout>