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
                            <h3 class="mb-0">
                                @if (auth()->user()->user_type == 6)
                                    Profil Pewaris
                                @else
                                    Profil Pentadbir Harta
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    @include('inc.alert')
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile.inheritance.admin.update', $profile->id) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">
                                                Maklumat Profil{!! $profile->isVerified() ? ' &nbsp;<i class="fas fa-check-circle"></i>' : '' !!}
                                            </a>
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
                                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Individu" value="{{ old('name', $profile->name) }}" required{{ $profile->isVerified() ? ' readonly' : '' }}>
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
                                                        <input id="icno" type="number" class="form-control" name="icno" placeholder="No. Kad Pengenalan" value="{{ old('icno', $profile->icno) }}" required maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"{{ $profile->isVerified() ? ' readonly' : '' }}>
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
                                                        <textarea id="address" class="form-control" name="address" placeholder="Alamat Semasa" rows="5">{{ old('address', $profile->address) }}</textarea>
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
                                                            <input id="phone" type="tel" class="form-control" name="phone" placeholder="No. Telefon Bimbit" value="{{ old('phone', ltrim($profile->phone, '60')) }}" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
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
                                                        <input id="email" type="email" class="form-control" name="email" placeholder="Alamat Emel"  value="{{ old('email', $profile->email) }}" required>
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
                                                        @if ($profile->isVerified())
                                                            <input id="vessel_owner" type="text" class="form-control" name="pemilik_vesel" placeholder="Nama Pemilik Vesel" value="{{ old('pemilik_vesel', $profile->pemilik_vesel) }}" readonly>
                                                        @else
                                                            <select id="vessel_owner" class="form-control select2bs4" name="vessel_owner">
                                                                <option value="">Pilih Pemilik Vesel</option>
                                                                @foreach ($vessel_owners as $owner)
                                                                    <option value="{{ $owner->id }}"{{ old('vessel_owner', $profile->vessel_owner_id) == $owner->id ? ' selected' : '' }}>{{ $owner->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        @endif
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
                                                {{-- Column kiri: user_status dan relationship --}}
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="user_status" class="form-label">Status Pengguna</label>
                                                        @if ($profile->isVerified())
                                                            <input id="user_status" type="text" class="form-control" name="user_status" value="{{ old('user_status', Str::title(str_replace('_', ' ', $profile->status_pengguna))) }}" readonly>
                                                        @else
                                                            <select id="user_status" class="form-control" name="user_status" required>
                                                                <option value="waris"{{ strcasecmp(old('user_status', $profile->status_pengguna), 'waris') === 0 ? ' selected' : '' }}>Waris</option>
                                                                <option value="pentadbir_harta"{{ strcasecmp(old('user_status', $profile->status_pengguna), 'pentadbir_harta') === 0 ? ' selected' : '' }}>Pentadbir Harta</option>
                                                            </select>
                                                        @endif
                                                        @error('user_status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    {{-- Hubungan (jika pewaris) --}}
                                                    @if (auth()->user()->user_type == 6)
                                                    <div id="div_relationship" class="mb-5 mt-n2">
                                                        <label for="relationship" class="form-label">Hubungan Bersama Pemilik Vesel</label>
                                                        @if ($profile->isVerified())
                                                            <input id="relationship" type="text" class="form-control" name="relationship" value="{{ old('relationship', Str::title(str_replace('_', ' ', $profile->hubungan))) }}" readonly>
                                                        @else
                                                            <select id="relationship" class="form-control" name="relationship" required>
                                                                <option value="">-- Sila Pilih Hubungan --</option>
                                                                <option value="ibu_bapa"{{ strcasecmp(old('relationship', $profile->hubungan), 'ibu_bapa') === 0 ? ' selected' : '' }}>Ibu Bapa</option>
                                                                <option value="anak"{{ strcasecmp(old('relationship', $profile->hubungan), 'anak') === 0 ? ' selected' : '' }}>Anak</option>
                                                                <option value="suami_isteri"{{ strcasecmp(old('relationship', $profile->hubungan), 'suami_isteri') === 0 ? ' selected' : '' }}>Suami / Isteri</option>
                                                                <option value="datuk_nenek"{{ strcasecmp(old('relationship', $profile->hubungan), 'datuk_nenek') === 0 ? ' selected' : '' }}>Datuk / Nenek</option>
                                                                <option value="bapa_saudara"{{ strcasecmp(old('relationship', $profile->hubungan), 'bapa_saudara') === 0 ? ' selected' : '' }}>Bapa Saudara</option>
                                                                <option value="anak_saudara"{{ strcasecmp(old('relationship', $profile->hubungan), 'anak_saudara') === 0 ? ' selected' : '' }}>Anak Saudara</option>
                                                            </select>
                                                        @endif
                                                        @error('relationship')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                      @else
                                                        <input type="hidden" name="relationship" value="">
                                                    @endif
                                                </div>

                                                {{-- Column kanan: vessel --}}
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="vessel" class="form-label">Vesel Yang Terlibat</label>
                                                        @if ($profile->isVerified())
                                                            <input id="vessel" type="text" class="form-control" name="vessel" value="{{ old('vessel', $profile->no_vesel) }}" readonly>
                                                        @else
                                                            <div class="form-text mb-2" style="margin-top: 0px; color: red;">Sila pilih satu atau lebih vesel yang terlibat.</div>
                                                            <select id="vessel" class="form-control select2bs4" name="vessel[]" multiple required>
                                                                <option value="">Pilih Vesel</option>
                                                            </select>
                                                        @endif
                                                        @error('vessel')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
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
                                                    @if (!$profile->isSubmitted() && !$profile->isVerified())
                                                        <input id="doc1" type="file" class="form-control" name="doc1">
                                                    @endif
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_1) }}" class="{{ $profile->dokumen_sokongan_1 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_1) }}&nbsp;&nbsp;
                                                    </a>
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
                                                    @if (!$profile->isSubmitted() && !$profile->isVerified())
                                                        <input id="doc2" type="file" class="form-control" name="doc2">
                                                    @endif
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_2) }}" class="{{ $profile->dokumen_sokongan_2 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_2) }}&nbsp;&nbsp;
                                                    </a>
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
                                                    @if (!$profile->isSubmitted() && !$profile->isVerified())
                                                        <input id="doc3" type="file" class="form-control" name="doc3">
                                                    @endif
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_3) }}" class="{{ $profile->dokumen_sokongan_3 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_3) }}&nbsp;&nbsp;
                                                    </a>
                                                    @error('doc3')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="row mb-4">
                                                <div class="col-lg-4">
                                                    <label for="doc4" class="form-label">Dokumen Sokongan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <a href="{{ asset('storage/'.$profile->dokumen_sokongan_4) }}" class="{{ $profile->dokumen_sokongan_4 ? '' : 'd-none' }}" target="_blank">
                                                        {{ basename($profile->dokumen_sokongan_4) }}&nbsp;&nbsp;
                                                    </a>
                                                    <a href="javascript:void(0);" class="{{ $profile->dokumen_sokongan_4 ? '' : 'd-none' }}">
                                                        <i class="fas fa-times text-danger"></i>
                                                    </a>
                                                    <input id="doc4" type="file" class="form-control{{ $profile->dokumen_sokongan_4 ? ' d-none' : '' }}" name="doc4">
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
                                            @if ($profile->isSubmitted())
                                                <button type="button" class="btn btn-success" disabled>Hantar Semula</button>
                                            @elseif ($profile->isVerified())
                                                <button type="submit" class="btn btn-warning" name="action" value="update">Kemaskini</button>
                                            @else
                                                <button type="submit" class="btn btn-success" name="action" value="submit">Hantar Semula</button>
                                            @endif
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
    
    <script type="text/javascript">
    const vesselsByOwner = @json(
        $vessels->groupBy('user_id')->map(function ($group) {
            return $group->map(function ($v) {
                return ['id' => $v->id, 'no' => $v->vessel_no];
            });
        })
    );

    const selectedVessels = @json(explode(',', $profile->vessel_id));

    $(document).ready(function () {
        const ownerId = $('#vessel_owner').val();
        const $vesselSelect = $('#vessel');

        // Reset dropdown
        $vesselSelect.empty().append('<option value="">Pilih Vesel</option>');

       if (vesselsByOwner[ownerId]) {
            vesselsByOwner[ownerId].forEach(vessel => {
                const isSelected = selectedVessels.map(String).includes(String(vessel.id)) ? 'selected' : '';
                $vesselSelect.append(`<option value="${vessel.id}" ${isSelected}>${vessel.no}</option>`);
            });
        }


        $vesselSelect.trigger('change');

        $('#vessel_owner').on('change', function () {
            const newOwnerId = $(this).val();
            $vesselSelect.empty().append('<option value="">Pilih Vesel</option>');

            if (vesselsByOwner[newOwnerId]) {
                vesselsByOwner[newOwnerId].forEach(vessel => {
                    $vesselSelect.append(`<option value="${vessel.id}">${vessel.no}</option>`);
                });
            }

            $vesselSelect.val(null).trigger('change');
        });

        userStatusChange('#user_status');
            $('#user_status').on('change', function () {
                userStatusChange(this);
            });
    });


        function userStatusChange(user_status_id) {
            var user_status = $(user_status_id).find('option:selected').val() ?? '{{ $profile->status_pengguna }}';
            if (user_status == 'waris') {
                $('#div_relationship').removeClass('d-none');
                $('#doc1-label').text('Sijil Faraid (Mahkamah Syariah)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            } else if (user_status == 'pentadbir_harta') {
                $('#div_relationship').addClass('d-none');
                $('#doc1-label').text('Surat Pelantikan Pentadbir Harta (Mahkamah Majistret/Jabatan Ketua Pengarah Tanah & Galian Persekutuan/Amanahraya)');
                $('#doc2-label').text('Salinan Kad Pengenalan');
                $('#doc3-label').text('Dokumen Sokongan');
            }
        }
    </script>
@endpush
