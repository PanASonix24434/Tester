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
                            <h3 class="mb-0">Senarai Jeti dan Pangkalan</h3>
                            <small class="text-muted">Maklumat jeti dan pangkalan.</small>
                        </div>
                        <div>
                            <a href="{{ route('master-data.jetty-base.create') }}" class="btn btn-primary">
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

                                <section>
                                    <form method="GET" action="{{ route('master-data.jetty-base.index') }}"
                                        class="mb-4">
                                        <div class="row">
                                            <!-- Search by Name -->
                                            <div class="col-md mb-3">
                                                <label class="form-label">Nama Jeti / Pangkalan</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ request('name') }}"
                                                    placeholder="Cari nama jeti atau pangkalan...">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- State -->
                                            <div class="col-md mb-3">
                                                <label class="form-label">Negeri</label>
                                                <select name="state_id" id="state_id" class="form-select"
                                                    data-url="{{ route('master-data.jetty-base.getDistricts', ['state_id' => ':state_id']) }}">
                                                    <option value="">Pilih Negeri</option>
                                                    @foreach($states as $id => $name)
                                                    <option value="{{ $id }}" {{ request('state_id')==$id ? 'selected'
                                                        : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- District -->
                                            <div class="col-md mb-3">
                                                <label class="form-label">Daerah</label>
                                                <select name="district_id" id="district_id" class="form-select">
                                                    <option value="">Pilih Daerah</option>
                                                    @if(request('state_id') && $districts)
                                                    @foreach($districts as $id => $name)
                                                    <option value="{{ $id }}" {{ request('district_id')==$id
                                                        ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <!-- Parliament -->
                                            <!-- Parliament -->
                                            <div class="col-md mb-3">
                                                <label class="form-label">Parlimen</label>
                                                <select name="parliament_id" id="parliament_id" class="form-select"
                                                    data-url="{{ route('master-data.jetty-base.getDuns', ['parliament_id' => ':parliament_id']) }}">
                                                    <option value="">Pilih Parlimen</option>
                                                    @foreach($parliaments as $id => $name)
                                                    <option value="{{ $id }}" {{ request('parliament_id')==$id
                                                        ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- DUN -->
                                            <div class="col-md mb-3">
                                                <label class="form-label">DUN</label>
                                                <select name="dun_id" id="dun_id" class="form-select">
                                                    <option value="">Pilih DUN</option>
                                                    @if(request('parliament_id'))
                                                    @foreach($duns as $id => $name)
                                                    <option value="{{ $id }}" {{ request('dun_id')==$id ? 'selected'
                                                        : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state_id');
    const districtSelect = document.getElementById('district_id');
    const parliamentSelect = document.getElementById('parliament_id');
    const dunSelect = document.getElementById('dun_id');

    // Handle Negeri -> Daerah
    stateSelect.addEventListener('change', function () {
        const state_id = this.value;
        const url = this.getAttribute('data-url').replace(':state_id', state_id);
        districtSelect.innerHTML = '<option value="">-- Sila Pilih Daerah --</option>';

        if (state_id) {
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        districtSelect.add(new Option(name.toUpperCase(), id));
                    }
                })
                .catch(err => console.error('Error loading districts:', err));
        }
    });

    // Handle Parlimen -> DUN
    parliamentSelect.addEventListener('change', function () {
        const parliament_id = this.value;
        const url = this.getAttribute('data-url').replace(':parliament_id', parliament_id);
        dunSelect.innerHTML = '<option value="">-- Sila Pilih DUN --</option>';

        if (parliament_id) {
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    for (const [id, name] of Object.entries(data)) {
                        dunSelect.add(new Option(name.toUpperCase(), id));
                    }
                })
                .catch(err => console.error('Error loading DUN:', err));
        }
    });
});
                                        </script>
                                </section>


                                <div class="row mb-3 justify-content-center">
                                    <div class="col-auto d-flex gap-3 align-items-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-search me-1"></i> Cari
                                        </button>
                                        <a href="{{ route('master-data.jetty-base.index') }}" class="btn btn-secondary">
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
                                                <th>Nama Jeti / Pangkalan</th>
                                                <th>Daerah</th>
                                                <th>Negeri</th>
                                                <th>Parlimen</th>
                                                <th>DUN</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($jettyList as $index => $jetty)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $jetty->name }}</td>
                                                <td>{{ $jetty->district->name ?? '-' }}</td>
                                                <td>{{ $jetty->state->name ?? '-' }}</td>
                                                <td>{{ $jetty->parliament->parliament_name ?? '-' }}</td>
                                                <td>{{ $jetty->dun->parliament_seat_name ?? '-' }}</td>
                                                <td>
                                                    @if($jetty->is_active)
                                                    <span class="badge bg-success">Aktif</span>
                                                    @else
                                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Tiada data jeti atau
                                                    pangkalan.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>


                            </div>

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
