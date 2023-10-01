<form action="{{ route('modules.store') }}" method="post">
    @csrf
    <input type="hidden" name="module" value="{{ $module }}">
    @php
        $text = ($status) ? 'Disable' : 'Enable';
        $btn = ($status) ? 'btn-danger' : 'btn-success';
    @endphp
    <button type="submit" class="btn {{ $btn }} btn-sm" onclick="return confirm('Are you sure?')">{{ $text }}</button>
</form>