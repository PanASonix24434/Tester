@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div id="app-content">

    <!-- Container fluid -->
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="mb-0">Senarai Pejabat Urusan</h3>
                            <small class="text-muted">Maklumat pejabat urusan perikanan.</small>
                        </div>
                        <div>
                            <a href="{{ route('master-data.fisheries-office.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <div>
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card mb-4">

                            <div class="card-body">

                            </div>

                            {{-- <div class="card-body">

                                <form method="GET" action="{{ route('master-data.river-lake.index') }}" class="mb-4">

                                    <div class="row">
                                        <!-- Search by Name -->
                                        <div class="col-md mb-3">
                                            <label class="form-label">Nama Sungai / Tasik</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request('name') }}"
                                                placeholder="Cari nama sungai dan tasik...">
                                        </div>

                                    </div>
                                    <div class="row">

                                        <!-- State -->
                                        <div class="col-md  mb-3">
                                            <label class="form-label">Negeri</label>
                                            <select name="state_id" id="state_id" class="form-select"
                                                data-url="{{ route('master-data.river-lake.getDistricts', ['state_id' => ':state_id']) }}">
                                                <option value="">Pilih Negeri</option>
                                                @foreach($states as $id => $name)
                                                <option value="{{ $id }}" {{ request('state_id')==$id ? 'selected' : ''
                                                    }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- District -->
                                        <div class="col-md  mb-3">
                                            <label class="form-label">Daerah</label>
                                            <select name="district_id" id="district_id" class="form-select">
                                                <option value="">Pilih Daerah</option>
                                                @if(request('state_id'))
                                                @foreach($districts as $id => $name)
                                                <option value="{{ $id }}" {{ request('district_id')==$id ? 'selected'
                                                    : '' }}>{{ $name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 justify-content-center">
                                        <div class="col-auto d-flex gap-3 align-items-end">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-search me-1"></i> Cari
                                            </button>
                                            <a href="{{ route('master-data.river-lake.index') }}"
                                                class="btn btn-secondary">
                                                <i class="fas fa-sync-alt me-1"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                <hr><br>

                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 5%;">Bil.</th>
                                                <th>Nama Sungai / Tasik</th>
                                                <th>Daerah</th>
                                                <th>Negeri</th>
                                                <th>Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($riverList as $index => $river)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $river->name }}</td>
                                                <td>{{ $river->district->name ?? '-' }}</td>
                                                <td>{{ $river->state->name ?? '-' }}</td>
                                                <td>
                                                    @if($river->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                    @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tiada data jeti atau
                                                    pangkalan.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div> --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    $(document).on('input', "input[type=text]", function () {
            $(this).val(function (_, val) {
                return val.toUpperCase();
            });
        });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('state_id');
        const districtSelect = document.getElementById('district_id');

        stateSelect.addEventListener('change', function () {
            const state_id = this.value;
            const urlTemplate = this.getAttribute('data-url');
            const finalUrl = urlTemplate.replace(':state_id', state_id);

            districtSelect.innerHTML = '<option value="">-- Semua Daerah --</option>';

            if (state_id) {
                fetch(finalUrl)
                    .then(response => response.json())
                    .then(data => {
                        for (const [id, name] of Object.entries(data)) {
                            const option = new Option(name, id);
                            districtSelect.add(option);
                        }
                    })
                    .catch(error => console.error('Error loading districts:', error));
            }
        });
    });
</script>

@endpush
