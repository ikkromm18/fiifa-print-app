@props([
    'label' => 'Select an option',
    'name',
    'options' => [],
    'selected' => null,
])

@php
    $inputId = $attributes->get('id') ?? $name;
@endphp

<div>
    <label for="{{ $inputId }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ $label }}
    </label>

    <select id="{{ $inputId }}" name="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'bg-gray-50 border text-sm rounded-lg block w-full p-2.5 
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 
                        focus:ring-blue-500 focus:border-blue-500 ' .
                ($errors->has($name) ? 'border-red-500 dark:border-red-500' : 'border-gray-300'),
        ]) }}>
        <option disabled {{ is_null($selected) ? 'selected' : '' }}>Pilih Kategori</option>
        @foreach ($options as $id => $labelOption)
            <option value="{{ $id }}" {{ $selected == $id ? 'selected' : '' }}>
                {{ $labelOption }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
