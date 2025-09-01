<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Gambar </h4>
        </div>

        <div class="card-body">
            <!-- Enjin Details -->
            <h5 class="mb-3 text-primary">Gambar</h5>
            <!-- Engine Images Section -->
            <h5 class="mt-4 text-primary">Gambar Enjin</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $enjin->gambar_enjin ?? asset('images/no-image.png') }}" class="card-img-top img-fluid" alt="Gambar Enjin">
                        <div class="card-body text-center">
                            <p class="mb-0">Gambar Enjin</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $enjin->gambar_no_enjin ?? asset('images/no-image.png') }}" class="card-img-top img-fluid" alt="Gambar No. Enjin">
                        <div class="card-body text-center">
                            <p class="mb-0">Gambar No. Enjin</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $enjin->gambar_pev ?? asset('images/no-image.png') }}" class="card-img-top img-fluid" alt="Gambar Penanda Enjin Vesel (PEV)">
                        <div class="card-body text-center">
                            <p class="mb-0">Gambar Penanda Enjin Vesel (PEV)</p>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mt-4 text-primary">Gambar Tambahan</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $enjin->gambar_turbo ?? asset('images/no-image.png') }}" class="card-img-top img-fluid" alt="Gambar Turbo">
                        <div class="card-body text-center">
                            <p class="mb-0">Gambar Turbo</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $enjin->gambar_generator ?? asset('images/no-image.png') }}" class="card-img-top img-fluid" alt="Gambar Generator">
                        <div class="card-body text-center">
                            <p class="mb-0">Gambar Generator</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
