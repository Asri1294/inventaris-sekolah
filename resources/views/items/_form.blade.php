<div>
    <x-input-label for="code">
        Kode Barang <span class="text-red-600">*</span>
    </x-input-label>
    <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
        :value="old('code', $item->code ?? '')"
        placeholder="Contoh: BRG-001" />
    <x-input-error :messages="$errors->get('code')" class="mt-2" />
</div>

<div>
    <x-input-label for="name">
        Nama Barang <span class="text-red-600">*</span>
    </x-input-label>
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
        :value="old('name', $item->name ?? '')"
        placeholder="Contoh: Bola Basket" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="category_id">
        Kategori <span class="text-red-600">*</span>
    </x-input-label>
    <select id="category_id" name="category_id"
        class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">-- Pilih kategori --</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="stock">
        Stok <span class="text-red-600">*</span>
    </x-input-label>
    <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
        :value="old('stock', $item->stock ?? '')"
        placeholder="Contoh: 10" />
    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
</div>

<div>
    <x-input-label for="condition">
        Kondisi <span class="text-red-600">*</span>
    </x-input-label>
    <select id="condition" name="condition"
        class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">-- Pilih kondisi --</option>
        @foreach (['baik', 'rusak ringan', 'rusak berat'] as $condition)
            <option value="{{ $condition }}" @selected(old('condition', $item->condition ?? '') === $condition)>
                {{ ucfirst($condition) }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('condition')" class="mt-2" />
</div>