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
                            <h3 class="mb-0">Daftar Pengurus Vesel</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- row -->
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profile.vesselmanager.store') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <ul class="nav nav-line-bottom" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                          <a class="nav-link active" id="pills-card-info-tab" data-bs-toggle="pill" href="#pills-card-info" role="tab" aria-controls="pills-card-info" aria-selected="true">Maklumat Pengurus Vesel</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-4" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-card-info" role="tabpanel" aria-labelledby="pills-card-info-tab">
                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Butiran Am</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="select_manager" class="form-label">Pengerus Sedia Ada?</label>
                                                        <select id="select_manager" class="form-control select2bs4" name="select_manager">
                                                            <option value="">Pengurus Baru</option>
                                                            @foreach ($managers as $manager)
                                                                <option value="{{ $manager->id }}"{{ old('select_manager') == $manager->id ? ' selected' : '' }}
                                                                    data-name="{{ $manager->name }}"
                                                                    data-icno="{{ $manager->ref }}"
                                                                    data-phone="{{ $manager->phone }}"
                                                                    data-email="{{ $manager->email }}"
                                                                    data-is-bumiputera="{{ $manager->is_bumiputera ? 'true' : 'false' }}"
                                                                    data-ic-copy-url="{{ $manager->ic_copy_url }}"
                                                                    data-ic-copy-name="{{ $manager->ic_copy_name }}">
                                                                    {{ $manager->name.' ('.$manager->ref.')' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="icno" class="form-label">No. Kad Pengenalan</label>
                                                        <input id="icno" type="text" class="form-control" name="icno"
                                                            placeholder="No. Kad Pengenalan" value="{{ old('icno') }}"
                                                            required maxlength="12"
                                                            inputmode="numeric"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)">
                                                        @error('icno')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <div id="errIcno" class="text-danger small"></div> <!-- Fix the ID -->
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label for="name" class="form-label">Nama Pengurus Vesel</label>
                                                        <input id="name" type="text" class="form-control" name="name" placeholder="Nama Pengurus Vesel" value="{{ old('name') }}" required>
                                                        @error('name')
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
                                                            <span class="input-group-text">+60</span>
                                                            <input id="phone" type="tel" class="form-control" name="phone" placeholder="No. Telefon Bimbit" value="{{ old('phone') }}" required maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                                        </div>
                                                        @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-5">
                                                        <label for="email" class="form-label">Alamat Emel</label>
                                                        <input id="email" type="email" class="form-control" name="email" placeholder="Alamat Emel"  value="{{ old('email') }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <div id="email-error" class="text-danger small"></div>
                                                    </div>
                                                    <div class="mb-5 mt-5">
                                                        <label class="form-label text-danger">
                                                            Emel ini akan digunakan untuk semua urusan pelesenan. Sila pastikan emel ini sentiasa aktif. Sebarang perubahan emel perlu dikemaskini di bahagian profil.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-5">
                                                        <label class="form-label">Status Bumiputera</label>
                                                        <div class="form-check">
                                                            <input id="bumiputera_status1" class="form-check-input" type="radio" name="bumiputera_status" value="yes" required{{ old('bumiputera_status') == 'yes' ? ' checked' : '' }}>
                                                            <label for="bumiputera_status1" class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input id="bumiputera_status2" class="form-check-input" type="radio" name="bumiputera_status" value="no" required{{ old('bumiputera_status') == 'no' ? ' checked' : '' }}>
                                                            <label for="bumiputera_status2" class="form-check-label">Tidak</label>
                                                        </div>
                                                        @error('bumiputera_status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                            @php
                                            $userType = auth()->user()->user_type;
                                            @endphp

                                            @if ($userType != 2)
                                            <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Maklumat Vesel</label>
                                                    <hr class="mt-0 mb-0 text-info" style="border-top: 2px solid;">
                                                </div>

                                                <div class="col-lg-6">
                                                        <div class="mb-5">
                                                            <label for="vessel" class="form-label">No. Pendaftaran Vesel Yang Diuruskan</label>
                                                            <select id="vessel" class="form-control select2bs4" name="vessel[]" required multiple>
                                                                @foreach ($vessels as $vessel)
                                                                    <option value="{{ $vessel->id }}"{{ collect(old('vessel'))->contains($vessel->id) ? ' selected' : '' }}>
                                                                        {{ $vessel->vessel_no.' (Zon '.$vessel->zon.')' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('vessel')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                </div>
                                                @endif

                                            <div class="row">
                                                <div class="col-12 mb-4">
                                                    <label class="form-label text-info">Dokumen yang Perlu Dimuatnaik</label>
                                                    <hr class="mt-0 text-info" style="border-top: 2px solid;">
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="ic_copy" class="form-label">Salinan Kad Pengenalan</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="ic_copy" type="file" class="form-control" name="ic_copy" required>
                                                    <a href="#" id="ic_copy_uploaded" class="d-none" target="_blank"></a>
                                                    @error('ic_copy')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-5">
                                                <div class="col-lg-4">
                                                    <label for="surat_wakil_kuasa" class="form-label">Surat Wakil Kuasa daripada Pemilik kepada Pengurus Vesel <span style="color: red;">*</span></label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="surat_wakil_kuasa" type="file" class="form-control" name="surat_wakil_kuasa">
                                                    @error('surat_wakil_kuasa')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-lg-12 text-lg-center mt-3 mt-lg-0">
                                            <a href="{{ route('profile.vesselmanager.index') }}" class="btn btn-light">Kembali</a>
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
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('#select_manager').find('option:selected').val()) {
                selectManagerChange('#select_manager');
            }

            $('#select_manager').on('change', function () {
                selectManagerChange('#select_manager');
            });
        });

        function selectManagerChange(select_manager_id) {
            var manager_id = $(select_manager_id).find('option:selected').val();
            if (manager_id) {
                $('#name').attr('readonly', 'readonly');
                $('#icno').attr('readonly', 'readonly');
                $('#phone').attr('readonly', 'readonly');
                $('#email').attr('readonly', 'readonly');

                $('#name').val($(select_manager_id).find('option:selected').data('name'));
                $('#icno').val($(select_manager_id).find('option:selected').data('icno'));
                $('#phone').val($(select_manager_id).find('option:selected').data('phone'));
                $('#email').val($(select_manager_id).find('option:selected').data('email'));

                var manager_is_bumiputera = $(select_manager_id).find('option:selected').data('is-bumiputera');
                if (manager_is_bumiputera == true) {
                    $('#bumiputera_status1').prop('checked', true);
                } else if (manager_is_bumiputera == false) {
                    $('#bumiputera_status2').prop('checked', true);
                }

                var ic_copy_url = $(select_manager_id).find('option:selected').data('ic-copy-url');
                var ic_copy_name = $(select_manager_id).find('option:selected').data('ic-copy-name');
                if (ic_copy_url) {
                    $('#ic_copy').prop('required', false);
                    $('#ic_copy_uploaded').removeClass('d-none');
                    $('#ic_copy_uploaded').attr('href', ic_copy_url);
                    $('#ic_copy_uploaded').text(ic_copy_name);
                } else {
                    $('#ic_copy').prop('required', true);
                    $('#ic_copy_uploaded').addClass('d-none');
                    $('#ic_copy_uploaded').attr('href', '#');
                    $('#ic_copy_uploaded').text('');
                }
            } else {
                $('#name').removeAttr('readonly');
                $('#icno').removeAttr('readonly');
                $('#phone').removeAttr('readonly');
                $('#email').removeAttr('readonly');

                $('#name').val('');
                $('#icno').val('');
                $('#phone').val('');
                $('#email').val('');
                $('#bumiputera_status1').prop('checked', false);
                $('#bumiputera_status2').prop('checked', false);

                $('#ic_copy').prop('required', true);
                $('#ic_copy_uploaded').addClass('d-none');
                $('#ic_copy_uploaded').attr('href', '#');
                $('#ic_copy_uploaded').text('');
            }
        }
    </script>
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            const icInput = document.getElementById("icno").value;
            const errorLabel = document.getElementById("errIcno");

            // Validate format: exactly 12 digits
            if (!/^\d{12}$/.test(icInput)) {
                errorLabel.textContent = "Sila masukkan 12 digit No. Kad Pengenalan.";
                errorLabel.style.display = "block";
                e.preventDefault();
                return;
            }

            const yy = parseInt(icInput.substring(0, 2), 10);
            const mm = parseInt(icInput.substring(2, 4), 10);
            const dd = parseInt(icInput.substring(4, 6), 10);

            // Validate month and day (basic sanity check)
            if (mm < 1 || mm > 12 || dd < 1 || dd > 31) {
                errorLabel.textContent = "Format tarikh lahir dalam IC tidak sah.";
                errorLabel.style.display = "block";
                e.preventDefault();
                return;
            }

            // Determine century
            const currentYear = new Date().getFullYear();
            const fullYear = (yy <= currentYear % 100 ? 2000 : 1900) + yy;

            const birthDate = new Date(fullYear, mm - 1, dd);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            if (age < 18) {
                errorLabel.textContent = "Pengurus vesel mesti berumur sekurang-kurangnya 18 tahun.";
                errorLabel.style.display = "block";
                e.preventDefault();
            } else {
                errorLabel.style.display = "none";
            }
        });
        </script>

@endpush
