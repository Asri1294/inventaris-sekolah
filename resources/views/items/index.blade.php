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
                    <form method="GET" action="{{ route('items.index') }}" class="flex flex-wrap gap-2">
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

                        <x-primary-button>Cari</x-primary-button>
                        @if (request('search') || request('category_id') || request('condition'))
                            <a href="{{ route('items.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                        @endif
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
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>