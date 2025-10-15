{{-- Maklumat Pemohon Section --}}
<div class="mb-4">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Maklumat Pemohon</h6>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Nama Pemohon</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->name ?? 'N/A' }}
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Kad Pengenalan / No. Pendaftaran Syarikat</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->username ?? 'N/A' }}
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Emel</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->email ?? 'N/A' }}
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Jenis Pengguna</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    @if($applicant->user_type)
                        @php
                            $userTypes = [
                                'INDIVIDU' => 'Individu',
                                'SYARIKAT' => 'Syarikat',
                                'individual' => 'Individu',
                                'company' => 'Syarikat'
                            ];
                        @endphp
                        {{ $userTypes[$applicant->user_type] ?? $applicant->user_type }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Telefon</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->contact_number ?? 'N/A' }}
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">No. Telefon Bimbit</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->mobile_contact_number ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alamat Pemohon Section --}}
<div class="mb-4">
    <h6 class="text-primary font-weight-bold mb-3" style="border-bottom:1px solid #007bff;">Alamat Pemohon</h6>
    
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Alamat</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->address1 ?? '' }}
                    @if($applicant->address2)
                        <br>{{ $applicant->address2 }}
                    @endif
                    @if($applicant->address3)
                        <br>{{ $applicant->address3 }}
                    @endif
                    @if(!$applicant->address1 && !$applicant->address2 && !$applicant->address3)
                        N/A
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Poskod</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->postcode ?? 'N/A' }}
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Daerah</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    {{ $applicant->district ?? 'N/A' }}
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-bold" style="color: #1a1a1a;">Negeri</label>
                <div class="form-control-plaintext bg-light rounded p-2" style="color: #495057;">
                    @php
                        $helper = new \App\Models\Helper();
                    @endphp
                    {{ $applicant->state_id ? strtoupper($helper->getCodeMasterNameById($applicant->state_id)) : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Button -->
<div class="text-center mt-4">
    <button type="button" class="btn btn-sm" style="background-color: #F0F4F5; color: #000; border: 1px solid #F0F4F5; border-radius: 8px;" onclick="nextTab('butiran-status-tab')">
        Seterusnya <i class="fas fa-arrow-right ms-2" style="color: #000;"></i>
    </button>
</div>

