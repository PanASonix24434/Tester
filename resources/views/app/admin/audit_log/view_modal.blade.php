<div class="modal-header">
	<h5 class="modal-title h4" id="myLargeModalLabel">
		Lihat Audit Log
	</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	</button>
</div>
<div class="modal-body">
	<div class="table-responsive">
	<table class="table text-nowrap mb-0 table-centered table-hover">
	<!--<table class="table table-bordered table-hover table-sm" width="50%">-->
		<tbody>
			<tr>
				<th>Punca Modul</th>
				<td>{{ Module::localize($audit->source) }}</td>
			</tr>
			<tr>
				<th>{{ __('app.action') }}</th>
				<td>{{ Helper::localize($audit->action) }}</td>
			</tr>
			@if ($audit->details != '')
			<tr>
				<th style="vertical-align: top !important;">{{ __('app.details') }}</th>
				<td><pre id="json" class="p-0 mb-0 text-sm">{{ $audit->details }}</pre></td>
			</tr>
			@endif
			@if ($audit->exception != '')
			<tr>
				<th style="vertical-align: top !important;">{{ __('app.error') }}</th>
				<td><pre class="p-0 mb-0 text-sm">{{ $audit->exception }}</pre></td>
			</tr>
			@endif
			<tr>
				<th class="text-nowrap">Dimasukkan Oleh</th>
				<td>{!! !empty($audit->created_by) && !empty(App\Models\User::withTrashed()->find($audit->created_by)) ? App\Models\User::withTrashed()->find($audit->created_by)->name : '' !!} ({{ $audit->ip_address }})</td>
			</tr>
			<tr>
				<th class="text-nowrap">{{ __('app.audit_date') }}</th>
				<td>{{ $audit->created_at->format('d/m/Y h:i:s A') }} ({{ $audit->created_at->diffForHumans() }})</td>
			</tr>
		</tbody>
	</table>
	</div>
</div>

<script type="text/javascript">
	(function () {
    	var element = document.getElementById("json");
    	if (element != null) {
    		var obj = JSON.parse(element.innerText);
    		element.innerHTML = JSON.stringify(obj, undefined, 2);
    	}
	})();
</script>