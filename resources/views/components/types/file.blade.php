@props(['field', 'value' => null])
@php
    $file = null;
    $hasExisting = false;
    if ($value && isset($value['path'])) {
        $file = $value;
        $hasExisting = true;
        // Determine file type icon/style
        $ext = pathinfo($file['original_name'] ?? '', PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
    }
@endphp

<div class="group" 
     x-data="{ 
        isDropping: false, 
        previewUrl: null, 
        fileName: null, 
        fileSize: null,
        isImage: false,
        handleFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            this.fileName = file.name;
            this.fileSize = (file.size / 1024).toFixed(2) + ' KB';
            this.isImage = file.type.startsWith('image/');
            
            if (this.isImage) {
                const reader = new FileReader();
                reader.onload = (e) => this.previewUrl = e.target.result;
                reader.readAsDataURL(file);
            } else {
                this.previewUrl = null;
            }
        }
     }">
     
    <label for="{{ $field->slug }}" class="block text-sm font-bold text-gray-700 mb-1">
        {{ $field->name }}
        @if($field->required) <span class="text-red-500">*</span> @endif
    </label>

    @if($field->description)
        <p class="mb-3 text-xs text-gray-500">{{ $field->description }}</p>
    @endif

    {{-- Existing File Preview (Hidden if new file selected) --}}
    @if($hasExisting)
        <div x-show="!fileName" class="mb-3 p-3 bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 flex items-center justify-between group-hover:border-indigo-200">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-100 relative">
                     @if(isset($isImage) && $isImage && isset($file['url']))
                        <img src="{{ $file['url'] }}" alt="Preview" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                <div>
                   <p class="text-sm font-bold text-gray-900 truncate max-w-[200px]" title="{{ $file['original_name'] ?? 'File' }}">
                        {{ $file['original_name'] ?? 'Uploaded File' }}
                   </p>
                   <p class="text-xs text-gray-500 flex items-center mt-0.5">
                        <span class="font-medium text-emerald-600">Saved</span>
                        <span class="mx-1.5 text-gray-300">&bull;</span>
                        <span>{{ isset($file['size']) ? number_format($file['size'] / 1024, 2) . ' KB' : 'Unknown size' }}</span>
                        <span class="mx-1.5 text-gray-300">&bull;</span>
                        <a href="{{ $file['url'] ?? '#' }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline font-medium transition-colors">
                            View
                        </a>
                   </p>
                </div>
            </div>
        </div>
    @endif

    {{-- New Selection Preview --}}
    <div x-show="fileName" style="display: none;" class="mb-3 p-3 bg-indigo-50/60 rounded-xl border border-indigo-200 shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-white flex items-center justify-center overflow-hidden border border-indigo-100 shadow-sm">
                <template x-if="isImage && previewUrl">
                     <img :src="previewUrl" class="w-full h-full object-cover" />
                </template>
                <template x-if="!isImage || !previewUrl">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </template>
            </div>
            <div>
               <p class="text-sm font-bold text-gray-900 truncate max-w-[200px]" x-text="fileName"></p>
               <p class="text-xs text-indigo-600 flex items-center mt-0.5">
                    <span class="font-bold">New Selection</span>
                    <span class="mx-1.5 text-indigo-300">&bull;</span>
                    <span x-text="fileSize"></span>
               </p>
            </div>
        </div>
        <button type="button" @click="fileName = null; previewUrl = null; $refs.fileInput.value = ''" class="text-gray-400 hover:text-red-500 transition-colors p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    {{-- Drop Zone --}}
    <div class="relative group-hover:scale-[1.005] transition-transform duration-200">
        <div class="absolute inset-0 bg-white rounded-xl border-2 border-dashed border-gray-300 pointer-events-none transition-all duration-200"
             :class="{ 'border-indigo-500 bg-indigo-50/30 scale-105 shadow-xl': isDropping, 'group-hover:border-indigo-300 group-hover:bg-gray-50/50': !isDropping }"></div>
        
        <div class="relative flex flex-col items-center justify-center py-8 px-4 text-center cursor-pointer">
            <svg class="w-10 h-10 text-gray-300 mb-3 transition-colors duration-200 group-hover:text-indigo-400" :class="{ 'text-indigo-500 animate-bounce': isDropping }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <p class="text-sm text-gray-600 font-medium">
                <span class="text-indigo-600 font-bold hover:underline">Click to upload</span> or drag and drop
            </p>
            <p class="text-xs text-gray-400 mt-1">SVG, PNG, JPG or GIF (MAX. 10MB)</p>
            
            <input 
                x-ref="fileInput"
                type="file" 
                id="{{ $field->slug }}" 
                name="{{ $field->slug }}"
                @if($field->required && empty($file)) required @endif
                @change="handleFile($event)"
                @dragenter="isDropping = true"
                @dragleave="isDropping = false"
                @drop="isDropping = false; handleFile($event)"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
            >
        </div>
    </div>

    @error($field->slug)
        <p class="mt-2 text-sm font-medium text-red-600 flex items-center animate-pulse">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            {{ $message }}
        </p>
    @enderror
</div>
