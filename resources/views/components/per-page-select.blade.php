@props(['options' => [5, 10, 25, 50]])

@php
    $selected = in_array((int) request('per_page'), $options, true) ? (int) request('per_page') : 10;
@endphp

<label class="inline-flex items-center gap-2 text-sm text-gray-600">
    <span>Tampilkan</span>
    <select name="per_page" onchange="this.form.submit()"
        class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @foreach ($options as $option)
            <option value="{{ $option }}" @selected($selected === $option)>{{ $option }}</option>
        @endforeach
    </select>
    <span>data</span>
</label>
