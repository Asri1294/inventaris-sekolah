<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="['Barang' => route('items.index'), 'Tambah' => null]" />
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Tambah Barang</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('items.store') }}" class="space-y-6">
                    @csrf
                    @include('items._form')

                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('items.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>