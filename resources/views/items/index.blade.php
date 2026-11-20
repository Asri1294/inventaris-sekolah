<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Barang' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Barang</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <form method="GET" action="{{ route('items.index') }}"
                        class="flex flex-1 flex-wrap items-center justify-between gap-3 sm:mr-4">
                        <div class="flex flex-wrap gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau kode barang..."
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            <select name="category_id"
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="condition"
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Kondisi</option>
                                @foreach (['baik', 'rusak ringan', 'rusak berat'] as $condition)
                                    <option value="{{ $condition }}" @selected(request('condition') === $condition)>
                                        {{ ucfirst($condition) }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-gray-800 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                                </svg>
                            </button>
                            @if (request('search') || request('category_id') || request('condition'))
                                <a href="{{ route('items.index') }}" class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <x-per-page-select />
                    </form>
                    <a href="{{ route('items.create') }}"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                        + Tambah Barang
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Kode</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Nama Barang</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Kategori</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Stok</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Kondisi</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($items as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $items->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $item->code }}</td>
                                    <td class="px-4 py-2">{{ $item->name }}</td>
                                    <td class="px-4 py-2">{{ $item->category->name }}</td>
                                    <td class="px-4 py-2">{{ number_format($item->stock, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($item->condition) }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right">
                                        <a href="{{ route('items.edit', $item) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $items->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>