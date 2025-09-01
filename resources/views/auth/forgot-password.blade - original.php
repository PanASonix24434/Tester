@extends('auth.app')

@push('styles')
    <style type="text/css">

    </style>
@endpush

@section('content')
        
        <main class="container d-flex flex-column">
			<div class="row align-items-center justify-content-center g-0 min-vh-100">
                <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
					
                    <div class="position-absolute end-0 top-0 p-8">
                        <div class="dropdown">
							<button class="btn btn-ghost btn-icon rounded-circle" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
								<i class="bi theme-icon-active"></i>
								<span class="visually-hidden bs-theme-text">Toggle theme</span>
							</button>
							<ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
										<i class="bi theme-icon bi-sun-fill"></i>
										<span class="ms-2">Light</span>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
										<i class="bi theme-icon bi-moon-stars-fill"></i>
										<span class="ms-2">Dark</span>
									</button>
								</li>
								<li>
									<button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
										<i class="bi theme-icon bi-circle-half"></i>
										<span class="ms-2">Auto</span>
									</button>
								</li>
							</ul>
						</div>
                    </div>

                    <!-- Card -->
					<div class="card smooth-shadow-md">
						<!-- Card body -->
						<div class="card-body p-6">

                            <div class="mb-6 text-center">
                                <img src="{{ asset('images/jata.png') }}" alt="Jata" height="70" width="110">&nbsp;&nbsp;
								<a href="#">
                                    <img src="{{ asset('assets/images/brand/logo/logo1.png') }}" height="70" width="120" class="mb-2 text-inverse" alt="Image" />
                                </a>&nbsp;&nbsp;
                                <img src="{{ asset('images/dof_logo.jpg') }}" alt="DOF Logo" height="70" width="110">
							</div>

                            <!-- Form -->
							<form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-group">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('auth.email_register') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('email')
                                <span id="email_error" class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <!-- Checkbox -->
								<div class="d-lg-flex justify-content-between align-items-center mb-4">
								</div>

                                <div>
									<!-- Button -->
									<div class="d-grid">
										<button type="submit" class="btn btn-primary">{{ __('auth.send_password_reset_link') }}</button>
									</div>

									<div class="d-md-flex justify-content-between mt-4">
										<div class="mb-2 mb-md-0">
                                            <a href="{{ route('login') }}" class="fs-5">Log Masuk</a>
										</div>
										<div>
											<a href="{{ route('register') }}" class="fs-5">Daftar Pengguna Baru</a>
										</div>
									</div>
								</div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </main>

@endsection
@push('scripts')
<script type="text/javascript">

    //Display success message
    var msgSuccess = '{{Session::get('email_success')}}';
    var existSuccess = '{{Session::has('email_success')}}';
    if(existSuccess){
        alert(msgSuccess);
    }

</script>
@endpush