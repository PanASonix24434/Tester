<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"  style="color: white;">Pematuhan</h4>
        </div>

        <div class="card-body">
           
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
                
                       
                
            </div>
            
        </div>
    </div>
</div>
