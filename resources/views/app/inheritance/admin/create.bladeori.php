@extends('layouts.app_new')

@section('content')
    <!-- Page Content -->
    <div id="app-content">
        <!-- Container fluid -->
        <div class="app-content-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div class="mb-5">
                            <h3 class="mb-0">Daftar Sebagai Pentadbir Harta</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile.inheritance.admin.store') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">Maklumat Pentadbir Harta</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-card-info" role="tabpanel" aria-labelledby="pills-card-info-tab">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label text-info">Butiran Am Individu</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="name" class="form-label">Nama Individu</label>
                                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Individu" value="{{ old('name', auth()->user()->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="icno" class="form-label">No. Kad Pengenalan</label>
                                                        <input id="icno" type="number" class="form-control" name="icno" placeholder="No. Kad Pengenalan" value="{{ old('icno', auth()->user()->username) }}" required maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
                                                        @error('icno')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="address" class="form-label">Alamat Semasa</label>
                                                        <textarea id="address" class="form-control" name="address" placeholder="Alamat Semasa" rows="5">{{ old('address') }}</textarea>
                                                        @error('address')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="phone" class="form-label">No. Telefon Bimbit</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="phone">+60</span>
                                                            <input id="phone" type="tel" class="form-control" name="phone" placeholder="No. Telefon Bimbit" value="{{ old('phone') }}" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                                        </div>
                                                        @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Alamat Emel</label>
                                                        <input id="email" type="email" class="form-control" name="email" placeholder="Alamat Emel"  value="{{ Auth::user()->email }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel_owner" class="form-label">Nama Pemilik Vesel yang Terlibat</label>
                                                        <select id="vessel_owner" class="form-control select2bs4" name="vessel_owner">
                                                            <option value="">Pilih Pemilik Vesel</option>
                                                            @foreach ($vessel_owners as $owner)
                                                                <option value="{{ $owner->id }}"{{ old('vessel_owner') == $owner->id ? ' selected' : '' }}>
                                                                    {{ $owner->name }} ({{ $owner->username }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-2 mt-5">
                                                    <label class="form-label text-info">Hubungkait Antara Pemilik Vesel</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="user_status" class="form-label">Status Pengguna</label>
                                                        <select id="user_status" class="form-control" name="user_status" required>
                                                            <option value="pentadbir_harta"{{ strcasecmp(old('user_status'), 'pentadbir_harta') === 0 ? ' selected' : '' }}>
                                                                Pentadbir Harta
                                                            </option>
                                                        </select>
                                                        @error('user_status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel" class="form-label">Vesel Yang Terlibat</label>
                                                        <select id="vessel" class="form-control select2bs4" name="vessel[]" multiple required>
                                                            <option value="">Pilih Vesel</option>
                                                        </select>
                                                        @error('vessel')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                        <script>
                                                            // Group vessels by owner_id
                                                            const vesselsByOwner = @json(
                                                                $vessels->groupBy('user_id')->map(function ($group) {
                                                                    return $group->map(function ($v) {
                                                                        return ['id' => $v->id, 'no' => $v->vessel_no];
                                                                    });
                                                                })
                                                            );
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 mb-2 mt-5">
                                                    <label class="form-label text-info">Dokumen yang Perlu Dimuatnaik</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc1-label" for="doc1" class="form-label">Surat Amanahraya (Pelantikan Pentadbir Pusaka / Keputusan Waris Pemilik)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="doc1" type="file" class="form-control" name="doc1" required>
                                                    @error('doc1')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc2-label" for="doc2" class="form-label">Surat Majistret</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="doc2" type="file" class="form-control" name="doc2" required>
                                                    @error('doc2')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc3-label" for="doc3" class="form-label">Surat (Jabatan Ketua Pengarah Tanah & Galian Persekutuan)</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="doc3" type="file" class="form-control" name="doc3">
                                                    @error('doc3')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label id="doc4-label" for="doc4" class="form-label">Dokumen Sokongan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="doc4" type="file" class="form-control" name="doc4" required>
                                                    @error('doc4')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <button type="submit" class="btn btn-success">Hantar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('inc.form_script')
    @include('inc.sweetalert')
    <script>
        
        $(document).ready(function () {
            $('#vessel_owner').on('change', function () {
                const ownerId = $(this).val();
                const $vesselSelect = $('#vessel');

                // Clear and reset options
                $vesselSelect.empty().append('<option value="">Pilih Vesel</option>');

                // Populate relevant vessels
                if (vesselsByOwner[ownerId]) {
                    vesselsByOwner[ownerId].forEach(vessel => {
                        $vesselSelect.append(`<option value="${vessel.id}">${vessel.no}</option>`);
                    });
                }

                $vesselSelect.trigger('change'); // refresh select2
            });
        });

        function userStatusChange(ddl_user_status_id) {
            var user_status = $(ddl_user_status_id).find('option:selected').val();
            if (user_status == 'waris') {
                $('#doc1-label').text('Sijil Faraid (Mahkamah Syariah)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            } else if (user_status == 'pentadbir_harta') {
                $('#doc1-label').text('Surat Pelantikan Pentadbir Harta (Mahkamah Majistret/Jabatan Ketua Pengarah Tanah & Galian Persekutuan/Amanahraya)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            }
        }
    </script>
@endpush
