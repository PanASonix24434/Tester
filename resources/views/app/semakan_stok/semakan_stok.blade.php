@extends('layouts.app')

@section('content')
<div id="app-content">
    <div class="app-content-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="mt-3 mb-2">Semakan</h2>
                    <div style="background:#fff; border:1px solid #e3e6f0; box-shadow:0 2px 8px rgba(0,0,0,0.03); border-radius:8px; padding:0 0 24px 0;">
                        <div class="fw-bold" style="background:#1890ff;color:white;padding:12px 16px;font-size:18px;border-top:3px solid #1890ff;border-radius:8px 8px 0 0;">Kemaskini Status Semasa Stok</div>
                        <div class="card mb-3" style="border:none;border-bottom:1.5px solid #1890ff; border-radius:0;">
                            <div class="card-header bg-white border-bottom-0" style="border-bottom:1.5px solid #1890ff;">
                                <span class="fw-bold">Maklumat Status Stok Semasa</span>
                            </div>
                            <div class="card-body pb-2 pt-2">
                                <form method="GET" action="">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 fw-bold">Tahun:</div>
                                        <div class="col-md-11">
                                            <select name="tahun" class="form-control" onchange="this.form.submit()">
                                                <option value="">-- Pilih Tahun --</option>
                                                @php
                                                    $years = \App\Models\StatusStock::whereNotNull('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
                                                @endphp
                                                @foreach($years as $year)
                                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <ul class="nav nav-tabs mb-3" style="padding-left:16px; padding-right:16px;">
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab', 'senarai_status') == 'senarai_status' ? 'active' : '' }}" style="color: #007bff;" href="?tab=senarai_status&tahun={{ request('tahun') }}">Senarai Status</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'dokumen_permohonan' ? 'active' : '' }}" style="color: #007bff;" href="?tab=dokumen_permohonan&tahun={{ request('tahun') }}">Dokumen Permohonan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') == 'tindakan' ? 'active' : '' }}" style="color: #007bff;" href="?tab=tindakan&tahun={{ request('tahun') }}">Tindakan</a>
                            </li>
                        </ul>

                        @if(request('tab', 'senarai_status') == 'senarai_status')
                            @include('app.semakan_stok.senarai_status')
                        @elseif(request('tab') == 'dokumen_permohonan')
                            @include('app.semakan_stok.dokumen_permohonan')
                        @elseif(request('tab') == 'tindakan')
                            @include('app.semakan_stok.tindakan')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    console.log('Main semakan_stok script loaded');
    
    // Update all tab links when year changes
    $('select[name="tahun"]').on('change', function() {
        const selectedYear = $(this).val();
        const currentTab = '{{ request("tab", "senarai_status") }}';
        
        // Update all tab links with the new year
        $('.nav-link').each(function() {
            const href = $(this).attr('href');
            const tabName = href.split('tab=')[1].split('&')[0];
            $(this).attr('href', `?tab=${tabName}&tahun=${selectedYear}`);
        });
    });
    
    // Auto-save when changing tabs
    $('.nav-link').on('click', function(e) {
        const currentTab = '{{ request("tab", "senarai_status") }}';
        const targetTab = $(this).attr('href').split('tab=')[1].split('&')[0];
        
        // Only auto-save if we're leaving dokumen_permohonan tab
        if (currentTab === 'dokumen_permohonan' && targetTab !== 'dokumen_permohonan') {
            e.preventDefault();
            
            // Check if there's form data to save
            const form = document.getElementById('dokumenForm');
            if (form) {
                const formData = new FormData(form);
                const fileInput = document.getElementById('dokumen_kelulusan_kpp');
                
                // Only save if there's actual data
                if (fileInput.files.length > 0 || localStorage.getItem('dokumen_permohonan_' + '{{ auth()->id() }}' + '_' + '{{ request("tahun", $selectedYear ?? date("Y")) }}')) {
                    // Show loading message
                    const originalText = $(this).text();
                    $(this).text('Menyimpan...');
                    $(this).addClass('disabled');
                    
                    // Add pengesahan status if exists
                    const storageKey = 'dokumen_permohonan_' + '{{ auth()->id() }}' + '_' + '{{ request("tahun", $selectedYear ?? date("Y")) }}';
                    const savedData = localStorage.getItem(storageKey);
                    if (savedData) {
                        const data = JSON.parse(savedData);
                        if (data.pengesahan_status) {
                            formData.append('pengesahan_status', data.pengesahan_status);
                        }
                    }
                    
                    // Save to database
                    fetch('{{ route("semakan-stok.store-draft") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear localStorage after successful save
                            localStorage.removeItem(storageKey);
                            
                            // Navigate to target tab
                            window.location.href = $(this).attr('href');
                        } else {
                            alert('Ralat! ' + data.message);
                            // Restore button state
                            $(this).text(originalText);
                            $(this).removeClass('disabled');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ralat semasa menyimpan data. Sila cuba lagi.');
                        // Restore button state
                        $(this).text(originalText);
                        $(this).removeClass('disabled');
                    });
                } else {
                    // No data to save, just navigate
                    window.location.href = $(this).attr('href');
                }
            } else {
                // No form, just navigate
                window.location.href = $(this).attr('href');
            }
        }
    });
});
</script>
@endsection 