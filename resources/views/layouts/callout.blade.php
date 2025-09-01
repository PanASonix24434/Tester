@foreach (['c_success', 'c_info', 'c_warning', 'c_danger'] as $key)
	@if (session()->has($key))
		<div class="callout callout-{{ ltrim($key, 'c_') }}">
			<p>{!! session()->get($key) !!}</p>
		</div>
	@endif
@endforeach