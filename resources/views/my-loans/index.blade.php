<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Peminjaman Saya' => null]" />
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Peminjaman Saya</h2>
            <a href="{{ route('my-loans.create') }}"
               class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">
                Ajukan Peminjaman
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('my-loans.index') }}"
                    class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau kode barang..."
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
                            <a href="{{ route('my-loans.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                        @endif
                    </div>

                    <x-per-page-select />
                </form>
                <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Tanggal Pinjam</th>
                            <th class="px-4 py-3">Jatuh Tempo</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $loan->item->name }}</td>
                                <td class="px-4 py-3">{{ number_format($loan->quantity, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $loan->loan_date->locale('id')->translatedFormat('j M Y') }}</td>
                                <td class="px-4 py-3">{{ $loan->due_date->locale('id')->translatedFormat('j M Y') }}</td>
                                <td class="px-4 py-3">{{ ucfirst($loan->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <div class="mt-4">{{ $loans->onEachSide(1)->links() }}</div>
        </div>
    </div>
</x-app-layout>