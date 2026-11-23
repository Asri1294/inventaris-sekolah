<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Peminjaman' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Peminjaman</h2>
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
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />
            
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <form method="GET" action="{{ route('loans.index') }}"
                        class="flex flex-1 flex-wrap items-center justify-between gap-3 sm:mr-4">
                        <div class="flex flex-wrap gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari peminjam atau barang..."
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            <select name="status"
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected(request('status') === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-gray-800 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                                </svg>
                               
                            </button>
                            @if (request('search') || request('status'))
                                <a href="{{ route('loans.index') }}" class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                
                            </a>
                            @endif
                        </div>

                        <x-per-page-select />
                    </form>
                    <a href="{{ route('loans.create') }}"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                        + Catat Peminjaman
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Peminjam</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Barang</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Jumlah</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Tanggal Pinjam</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Jatuh Tempo</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Status</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($loans as $loan)
                                <tr>
                                    <td class="px-4 py-2">{{ $loans->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $loan->user->name }}</td>
                                    <td class="px-4 py-2">{{ $loan->item->name }}</td>
                                    <td class="px-4 py-2">{{ number_format($loan->quantity, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $loan->loan_date->locale('id')->translatedFormat('j M Y') }}</td>
                                    <td class="px-4 py-2">{{ $loan->due_date->locale('id')->translatedFormat('j M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $badge[$loan->status] ?? '' }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($loan->status === 'diajukan')
                                            <div class="flex gap-2">
                                                <form method="POST" action="{{ route('loans.approve', $loan) }}"
                                                    onsubmit="return confirm('Setujui pengajuan ini? Stok akan dikurangi.')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="rounded-md bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-500">
                                                        Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('loans.reject', $loan) }}"
                                                    onsubmit="return confirm('Tolak pengajuan ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-500">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                            @elseif (in_array($loan->status, ['dipinjam', 'terlambat']))
                                            <a href="{{ route('loans.return.create', $loan) }}"
                                                class="rounded-md bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-500">
                                                Kembalikan
                                            </a>
                                        @else
                                            <form method="POST" action="{{ route('loans.destroy', $loan) }}"
                                                onsubmit="return confirm('Hapus riwayat peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-md bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-500">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $loans->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>