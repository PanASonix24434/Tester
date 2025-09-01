<div class="tab-pane fade" id="kru" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tab['kru']['description'] }}</h4>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#kru_aktif" 
                    type="button" role="tab">
                    {{ $tabkru['kru_aktif']['name'] }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#kru_tempatan" 
                    type="button" role="tab">
                    {{ $tabkru['kru_tempatan']['name'] }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#penduduk_tetap" 
                    type="button" role="tab">
                    {{ $tabkru['penduduk_tetap']['name'] }}
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#kru_asing" 
                    type="button" role="tab">
                    {{ $tabkru['kru_asing']['name'] }}
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            @include('app.profile.tab.tabkru.kruaktif', ["kru_aktif" => $kru_aktif])
            @include('app.profile.tab.tabkru.krutempatan', ["kru_tempatan" => $kru_tempatan])
            @include('app.profile.tab.tabkru.penduduktetap', ["penduduk_tetap" => $penduduk_tetap])
            @include('app.profile.tab.tabkru.kruasing', ["kru_asing" => $kru_asing])
        </div>

        <!-- Footer -->
        <div class="card-footer d-flex justify-content-center mt-2">
            <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                Kembali <i class="icon-xxs"></i>
            </a>
        </div>
    </div>
</div>
