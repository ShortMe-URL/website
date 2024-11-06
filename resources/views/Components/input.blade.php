@props(['name', 'showerrors' => false])

<div class="input-content">
    <input name="{{ $name }}"
        {{ $attributes->merge(['class' => $showerrors && $errors->first($name) ? 'is-invalid' : '']) }}
        value="{{ old($name) }}">
    {!! $showerrors ? $errors->first($name, '<p class="alert-danger">:message</p>') : '' !!}
</div>
