<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajukan Peminjaman</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('my-loans.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="item_id">
                            Barang <span class="text-red-500">*</span>
                        </x-input-label>
                        <select id="item_id" name="item_id" autofocus
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih barang --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" @selected(old('item_id') == $item->id)>
                                    {{ $item->name }} (stok: {{ $item->stock }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantity">
                            Jumlah <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="quantity" name="quantity" type="number" min="1"
                                      class="mt-1 block w-full" placeholder="Contoh: 2"
                                      :value="old('quantity')" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="loan_date">
                            Tanggal Pinjam <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="loan_date" name="loan_date" type="date"
                                      class="mt-1 block w-full"
                                      :value="old('loan_date', now()->toDateString())" />
                        <x-input-error :messages="$errors->get('loan_date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="due_date">
                            Jatuh Tempo <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="due_date" name="due_date" type="date"
                                      class="mt-1 block w-full"
                                      :value="old('due_date')" />
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700">
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('my-loans.index') }}" class="text-sm text-gray-600 hover:underline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>