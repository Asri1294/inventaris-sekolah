<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Kategori' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Kategori</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <form method="GET" action="{{ route('categories.index') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama kategori..."
                            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <x-primary-button>Cari</x-primary-button>
                        @if (request('search'))
                            <a href="{{ route('categories.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                        @endif
                    </form>

                    <a href="{{ route('categories.create') }}"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                        + Tambah Kategori
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Nama Kategori</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Jumlah Barang</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="px-4 py-2">{{ $categories->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $category->name }}</td>
                                    <td class="px-4 py-2">{{ number_format($category->items_count, 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right">
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>