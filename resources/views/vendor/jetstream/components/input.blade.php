@props(['disabled' => false, 'action' => 'create'])

<input
    {{ $disabled ? 'disabled' : '' }}
    {{ strcasecmp($action, 'destroy') == 0 ? 'readonly' : '' }}
    {{ strcasecmp($action, 'view'   ) == 0 ? 'readonly' : '' }}
    {!! $attributes->merge(['class' => 'form-input rounded-md shadow-sm block mt-1 w-full']) !!}>
