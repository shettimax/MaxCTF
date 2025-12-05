@props(['type'])
<div class="alert shadow-sm alert-{{ $type }}" role="alert">{{ $slot }}</div>
