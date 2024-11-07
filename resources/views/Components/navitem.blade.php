@props(['href'])

<li class="{{ request()->url() == $href ? 'active' : '' }}">
    <a href="{{ $href }}">{{ $slot }}</a>
</li>