@foreach (['success', 'info', 'warning', 'danger'] as $key)
	@if (session()->has($key))
		<div id="alert" class="alert alert-{{ $key }} alert-dismissable" role="alert">
			<button href="#" class="close" data-dismiss="alert" aria-label="close">&times;</button>
			@if (strcasecmp($key, 'success') === 0) 
				<i class="fas fa-check"></i> 
			@elseif (strcasecmp($key, 'info') === 0)
				<i class="fas fa-info-circle"></i>
			@elseif (strcasecmp($key, 'warning') === 0)
				<i class="fas fa-exclamation-triangle"></i>
			@else
				<i class="fas fa-ban"></i>
			@endif
			&nbsp;
			{!! session()->get($key) !!}
		</div>
	@endif
@endforeach