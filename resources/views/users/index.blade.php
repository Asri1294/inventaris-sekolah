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
                    <form method="GET" action="{{ route('users.index') }}" class="flex flex-wrap gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <select name="role"
                            class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Peran</option>
                            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                            <option value="user" @selected(request('role') === 'user')>Pengguna</option>
                        </select>
                        <x-primary-button>Cari</x-primary-button>
                        @if (request('search') || request('role'))
                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">Reset</a>
                        @endif
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>