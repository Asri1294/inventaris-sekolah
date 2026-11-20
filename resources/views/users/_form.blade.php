@csrf

<div>
    <x-input-label for="name">
        Nama <span class="text-red-600">*</span>
    </x-input-label>
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
        :value="old('name', $user?->name)" placeholder="Nama lengkap" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="email">
        Email <span class="text-red-600">*</span>
    </x-input-label>
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
        :value="old('email', $user?->email)" placeholder="nama@sekolah.test" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-input-label for="role">
        Peran <span class="text-red-600">*</span>
    </x-input-label>
    <select id="role" name="role"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="user" @selected(old('role', $user?->role ?? 'user') === 'user')>Pengguna</option>
        <option value="admin" @selected(old('role', $user?->role ?? 'user') === 'admin')>Admin</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

<div>
    <x-input-label for="password">
        Kata Sandi @if (! $user)<span class="text-red-600">*</span>@endif
    </x-input-label>
    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
        placeholder="Kata sandi" autocomplete="new-password" />
    @if ($user)
        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti kata sandi.</p>
    @endif
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<div>
    <x-input-label for="password_confirmation">
        Konfirmasi Kata Sandi @if (! $user)<span class="text-red-600">*</span>@endif
    </x-input-label>
    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
        class="mt-1 block w-full" placeholder="Ulangi kata sandi" autocomplete="new-password" />
</div>

<div class="flex items-center gap-3">
    <x-primary-button>Simpan</x-primary-button>
    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
</div>