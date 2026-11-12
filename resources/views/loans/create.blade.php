<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Peminjaman' => route('loans.index'), 'Catat' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Catat Peminjaman</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('loans.store') }}" class="space-y-6"
                    onsubmit="this.querySelector('button[type=submit]').disabled = true">
                    @csrf

                    <div>
                        <x-input-label for="user_id">
                            Peminjam <span class="text-red-600">*</span>
                        </x-input-label>
                        <select id="user_id" name="user_id" autofocus
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih peminjam --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="item_id">
                            Barang <span class="text-red-600">*</span>
                        </x-input-label>
                        <select id="item_id" name="item_id"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            Jumlah <span class="text-red-600">*</span>
                        </x-input-label>
                        <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full"
                            :value="old('quantity')" placeholder="Contoh: 2" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="loan_date">
                            Tanggal Pinjam <span class="text-red-600">*</span>
                        </x-input-label>
                        <x-text-input id="loan_date" name="loan_date" type="date" class="mt-1 block w-full"
                            :value="old('loan_date', now()->toDateString())" />
                        <x-input-error :messages="$errors->get('loan_date')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="due_date">
                            Jatuh Tempo <span class="text-red-600">*</span>
                        </x-input-label>
                        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
                            :value="old('due_date')" />
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('loans.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>