<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Pengguna' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <form method="GET" action="{{ route('users.index') }}"
                        class="flex flex-1 flex-wrap items-center justify-between gap-3 sm:mr-4">
                        <div class="flex flex-wrap gap-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau email..."
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <select name="role"
                                class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Peran</option>
                                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                                <option value="user" @selected(request('role') === 'user')>Pengguna</option>
                            </select>
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-md bg-gray-800 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                                </svg>
                                
                            </button>
                            @if (request('search') || request('role'))
                                <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1.5 rounded-md bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-200 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    
                                </a>
                            @endif
                        </div>

                        <x-per-page-select />
                    </form>
                    <a href="{{ route('users.create') }}"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-indigo-500">
                        + Tambah Akun
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">No</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Nama</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Email</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Peran</th>
                                <th class="px-4 py-2 text-right font-medium text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $users->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">
                                        @if ($user->isAdmin())
                                            <span class="rounded-full bg-indigo-100 px-2 py-1 text-xs font-medium text-indigo-800">Admin</span>
                                        @else
                                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">Pengguna</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-2 text-right">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @if (! $user->is(auth()->user()))
                                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-3 text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>