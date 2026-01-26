@extends('custom-fields::layout')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Custom Field Details</h1>
        <a href="{{ route('custom-fields.index') }}" class="text-blue-500 hover:text-blue-800">Back to List</a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <p>{{ $customField->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Model</label>
            <p>{{ $customField->model }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
            <p>{{ $customField->type }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Required</label>
            <p>{{ (isset($customField->validation_rules['required']) && $customField->validation_rules['required']) ? 'Yes' : 'No' }}</p>
        </div>
    </div>
</div>
@endsection