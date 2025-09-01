<div class="tab-pane fade" id="pematuhan" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ $tab['pematuhan']['description'] }}</h4>
        </div>

        <!-- Sub-tabs for Pematuhan -->
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabpematuhan as $key => $pematuhanItem)
                <li class="nav-item">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                        data-bs-target="#{{ $key }}" type="button" role="tab">
                        {{ $pematuhanItem['name'] }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-3">
            @foreach($tabpematuhan as $key => $pematuhanItem)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}" role="tabpanel">
                    @include("app.profile.tab.tabpematuhan.{$key}", ['pematuhan' => $pematuhan -> first()])
                </div>
            @endforeach
        </div>

        <div class="card-footer d-flex justify-content-center mt-2">
            <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">Kembali</a>
        </div>
    </div>
</div>
