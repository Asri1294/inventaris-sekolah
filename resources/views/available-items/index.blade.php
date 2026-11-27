<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Barang Tersedia' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Barang Tersedia</h2>
    </x-slot>

    @php
        $badge = [
            'baik' => 'bg-green-100 text-green-800',
            'rusak ringan' => 'bg-yellow-100 text-yellow-800',
            'rusak berat' => 'bg-red-100 text-red-800',
        ];
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('available-items.index') }}"
                    class="mb-4 flex flex-wrap items-center justify-between gap-3">
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

                       <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-indigo-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                            </svg>
                            
                        </button>
                        @if (request('search') || request('category_id'))
                            <a href="{{ route('available-items.index') }}"
                                class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                                
                            </a>
                        @endif
                    </div>

                    <x-per-page-select />
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
                                    <td class="px-4 py-2">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $badge[$item->condition] ?? '' }}">
                                            {{ ucfirst($item->condition) }}
                                        </span>
                                    </td>
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
                    {{ $items->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>