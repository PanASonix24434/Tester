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
				<!--<a href="#">
                                    <img src="{{ asset('assets/images/brand/logo/logo1.png') }}" height="70" width="120" class="mb-2 text-inverse" alt="Image" />
                                </a>&nbsp;&nbsp;-->
                                <img src="{{ asset('images/dof_logo.jpg') }}" alt="DOF Logo" height="70" width="110">
							</div>

                            @if (session('status'))
                                <div id="alert" class="alert alert-danger alert-dismissable d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ session('status') }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                      </button>
                                </div>
                                
                            @endif
                            @error('username')
                                <div id="alert" class="alert alert-danger alert-dismissable d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ $message }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                      </button>
                                </div>
                            @enderror
                            @error('password')
                                <div id="alert" class="alert alert-danger alert-dismissable d-flex align-items-center" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    <div>
                                        {{ $message }}
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            @enderror

                            <!-- Form -->
							<form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Username -->
								<div class="mb-3">
									<label for="username" class="form-label">No. Kad Pengenalan ( Tanpa '-' ) : </label>
									<input type="text" id="username" class="form-control" name="username" required="" maxlength="12" />
                                    <label id="errUsername" class="form-label" style="color:red; display:none;">Sila masukkan 12 digit No. Kad Pengenalan.</label>
								</div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Laluan : 
                                        <i class="fa fa-info-circle" style="font-size:18px;color:green" data-bs-toggle="tooltip" data-placement="top" 
                                        title="Panjang minimum 12 Aksara, Minimum 1 Huruf Kecil, 1 Huruf Besar, 1 Nombor, 1 Simbol">
                                        </i>
                                    </label>
                                </div>
                                <div class="input-group mt-3" >
                                    <input style="margin-top:-10px;" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="">
                                    <div class="input-group-append" style="margin-top:-10px;">                           
                                        <div class="input-group-text">
                                            <i  class="far fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkbox -->
								<div class="d-lg-flex justify-content-between align-items-center mb-4">
								</div>

                                <div>
									<!-- Button -->
									<div class="d-grid">
										<button type="submit" class="btn btn-primary">Log Masuk</button>
									</div>

									<div class="d-md-flex justify-content-between mt-4">
										<div class="mb-2 mb-md-0">
											<a href="{{ route('register') }}" class="fs-5">Daftar Pengguna Baru</a><br/>
                                            <a href="{{ route('welcome') }}" class="fs-5">Laman Utama</a>
										</div>
										<div>
											<a href="{{ route('password.request') }}" class="text-inherit fs-5">Lupa Kata Laluan ?</a>
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

    var errUsername = document.getElementById("errUsername");

    $("#username").keyup('input', function(event){

        this.value = this.value.replace(/[^0-9]/g, '');

        if ( $("#username").val().length != 12) {
            
            // If username is too short
            errUsername.style.display = "block";
        
        } else {
            
            // If there is no errors, clear the HTML
            errUsername.style.display = "none";
            event.preventDefault();    
            
        }
    })
        
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });

    //Display success message
    var msgSuccess = '{{Session::get('status_reset')}}';
    var existSuccess = '{{Session::has('status_reset')}}';
    if(existSuccess){
        alert(msgSuccess);
    }

</script>
@endpush