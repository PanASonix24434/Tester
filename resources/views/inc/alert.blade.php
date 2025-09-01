@foreach (['success', 'info', 'warning', 'danger'] as $key)
    @if (session()->has($key))
        <div class="alert alert-{{ $key }} alert-dismissible fade show" role="alert">
            {!! nl2br(session()->get($key)) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                {{-- <span aria-hidden="true">&times;</span> --}}
            </button>
        </div>
    @endif
@endforeach
