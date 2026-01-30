@props(['field', 'value' => null, 'inputName'])

<div class="flex items-center gap-3">
    <div class="relative w-12 h-12 rounded-xl overflow-hidden border border-gray-200 shadow-sm transition-all group-hover:border-indigo-300">
        <input type="color"
            name="{{ $inputName }}"
            id="{{ $field->name }}"
            value="{{ $value ?? '#4f46e5' }}"
            class="absolute inset-0 w-[200%] h-[200%] -top-1/2 -left-1/2 cursor-pointer bg-transparent border-none">
    </div>
    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Select Color</span>
</div>
