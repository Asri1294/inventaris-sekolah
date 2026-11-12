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
                    <form method="GET" action="{{ route('loans.index') }}" class="flex flex-wrap gap-2">
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

                        <x-primary-button>Cari</x-primary-button>
                        @if (request('search') || request('status'))
                            <a href="{{ route('loans.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                        @endif
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($loans as $loan)
                                <tr>
                                    <td class="px-4 py-2">{{ $loans->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $loan->user->name }}</td>
                                    <td class="px-4 py-2">{{ $loan->item->name }}</td>
                                    <td class="px-4 py-2">{{ number_format($loan->quantity, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $loan->loan_date->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">{{ $loan->due_date->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $badge[$loan->status] ?? '' }}">
                                            {{ ucfirst($loan->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $loans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>