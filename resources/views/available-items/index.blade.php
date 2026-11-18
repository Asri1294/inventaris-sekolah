<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Barang Tersedia' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Barang Tersedia</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('available-items.index') }}" class="mb-4 flex flex-wrap gap-2">
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

                    <x-primary-button>Cari</x-primary-button>
                    @if (request('search') || request('category_id'))
                        <a href="{{ route('available-items.index') }}"
                            class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                    @endif
                </form>

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
                                        <a href="{{ route('my-loans.create', ['item_id' => $item->id]) }}"
                                            class="rounded-md bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-500">
                                            Ajukan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada barang yang tersedia.
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