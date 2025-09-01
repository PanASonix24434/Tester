<!--<div id="delete-modal" class="modal fade" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modal-dialog-centered modal-dialog-zoom modal-delete">
		<div class="modal-content">
			<form id="delete-form" method="POST" action="#">
				@method('DELETE')
				@csrf
				<div class="modal-body text-center">
					<p class="badge badge-pill badge-warning badge-outline-2 mt-2" style="font-size:50px;"><i class="fas fa-exclamation"></i></p>
					<h2>{{ __('auth.are_you_sure') }}</h2>
					<div class="modal-text text-muted"></div>
					<div class="mt-3">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
						<button type="submit" class="btn btn-danger">{{ __('app.confirm_delete') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>-->

<!-- Modal -->
<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
	aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		<div class="modal-content">
			<form id="delete-form" method="POST" action="#">
			@method('DELETE')
			@csrf
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			  </div>
				<div class="modal-body text-center" style="font-size:18px;">
					<p class="badge badge-pill badge-warning badge-outline-2 mt-2" style="font-size:50px;"><i class="fas fa-exclamation"></i></p>
					<br/>
					Adakah anda pasti untuk memadam data berikut ?
					<hr>
				</div>
				<div class="text-lg-center">
					<button type="submit" class="btn btn-danger">
						Padam
					</button>
				</div><br/>
				<div></div>
			</form>
		</div>
	</div>
</div>