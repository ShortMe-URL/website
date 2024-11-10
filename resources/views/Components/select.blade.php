@props(['name', 'showerrors' => false])

<div class="input-content">
    <select name="{{ $name }}"
        {{ $attributes->merge(['class' => $showerrors && $errors->first($name) ? 'is-invalid' : '']) }}>
        {{ $slot }}
    </select>
    {!! $showerrors ? $errors->first($name, '<p class="alert-danger">:message</p>') : '' !!}
</div>
