<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 4 Kartu Statistik -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Card 1: Jumlah Barang -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 relative">
                    <div class="absolute top-4 right-4 text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Jumlah Barang</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['items'], 0, ',', '.') }}</p>
                </div>

                <!-- Card 2: Sedang Dipinjam -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 relative">
                    <div class="absolute top-4 right-4 text-indigo-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Sedang Dipinjam</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($stats['borrowed'], 0, ',', '.') }}</p>
                </div>

                <!-- Card 3: Terlambat -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 relative">
                    <div class="absolute top-4 right-4 text-red-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Terlambat</p>
                    <p class="mt-2 text-3xl font-semibold text-red-600">{{ number_format($stats['overdue'], 0, ',', '.') }}</p>
                </div>

                <!-- Card 4: Menunggu Persetujuan -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 relative">
                    <div class="absolute top-4 right-4 text-amber-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-600">{{ number_format($stats['pending'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Bagian Aksi Cepat -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('items.create') }}" class="flex items-center justify-center p-3 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 transition font-medium text-sm">
                            + Tambah Barang
                        </a>
                        <a href="{{ route('categories.create') }}" class="flex items-center justify-center p-3 bg-emerald-50 text-emerald-700 rounded-md hover:bg-emerald-100 transition font-medium text-sm">
                            + Tambah Kategori
                        </a>
                        <a href="{{ route('loans.create') }}" class="flex items-center justify-center p-3 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition font-medium text-sm">
                            + Catat Peminjaman
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center justify-center p-3 bg-gray-50 text-gray-700 rounded-md hover:bg-gray-200 transition font-medium text-sm border border-gray-200">
                            Kelola Pengguna
                        </a>
                    </div>
                </div>

                <!-- Bagian Peminjam Teraktif (Butuh data dari Controller) -->
                <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 border-b pb-2">Peminjam Teraktif</h3>
                    <div class="space-y-3">
                        @forelse ($topUsers as $index => $topUser)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-xs font-bold text-gray-600">{{ $index + 1 }}</span>
                                    <span class="text-sm font-medium text-gray-800">{{ $topUser->name }}</span>
                                </div>
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">{{ $topUser->loans_count }} Peminjaman</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>