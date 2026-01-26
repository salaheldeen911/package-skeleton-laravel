@props(['field', 'value' => null, 'inputName'])

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 rounded-2xl bg-gray-50/50 border border-gray-100">
    @foreach($field->options ?? [] as $option)
    <label class="relative flex items-center p-3 rounded-xl border border-transparent hover:bg-white hover:border-gray-100 hover:shadow-sm transition-all cursor-pointer group">
        <input type="radio"
            name="{{ $inputName }}"
            value="{{ $option }}"
            class="w-5 h-5 border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-all bg-white"
            {{ $value == $option ? 'checked' : '' }}>
        <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $option }}</span>
    </label>
    @endforeach
</div>