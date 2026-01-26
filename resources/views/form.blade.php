@props(['model' => null, 'modelClass' => null])

@php
$fields = collect();

if ($model) {
$fields = $model::customFields();
} elseif ($modelClass) {
// Ensure the class exists and works
if (class_exists($modelClass) && method_exists($modelClass, 'customFields')) {
$fields = $modelClass::customFields();
}
}
@endphp

<div class="custom-fields-container">
    @foreach($fields as $field)
    @php
    $handler = $field->handler();
    // Safe fallback if handler is missing
    if (!$handler) {
    continue;
    }
    $view = $handler->view();
    // Get value from model instance if available
    $value = $model ? $model->custom($field->name) : null;
    @endphp

    @include($view, ['field' => $field, 'value' => $value])
    @endforeach
</div>