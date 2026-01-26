@props(['field', 'value' => null, 'inputName'])

<select name="{{ $inputName }}"
    id="{{ $field->name }}"
    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white text-gray-900 font-medium appearance-none">
    <option value="">Select {{ $field->label ?? str_replace('_', ' ', $field->name) }}</option>
    @foreach($field->options ?? [] as $option)
    <option value="{{ $option }}" {{ $value == $option ? 'selected' : '' }}>
        {{ $option }}
    </option>
    @endforeach
</select>
<div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
    </svg>
</div>