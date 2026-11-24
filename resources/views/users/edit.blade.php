<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Pengguna' => route('users.index'), 'Edit' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
                    @method('PUT')
                    @include('users._form', ['user' => $user])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>