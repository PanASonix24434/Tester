@php
    $user = auth()->user();
    $userRole = strtolower($user->peranan ?? '');
    
    // Use the isOfficer value passed from controller, don't recalculate
    // $isOfficer is already set by the controller
@endphp

<div class="table-responsive">
    <table class="table table-sm w-100 align-middle mb-0 text-nowrap">
        <thead class="table-light text-secondary small text-uppercase">
            <tr>
                <th class="text-center" style="width: 50px;">Bil</th>
                @if($isOfficer)
                    <th style="width: 120px;">No. Rujukan</th>
                    <th style="width: 100px;">No. Vesel</th>
                    <th style="width: 80px;">Zon</th>
                    <th>Nama Permohonan</th>
                    <th style="width: 120px;">Tarikh Permohonan</th>
                    <th style="width: 150px;">Status</th>
                    <th class="text-center" style="width: 80px;">Tindakan</th>
                @else
                    {{-- Applicant view columns --}}
                    <th style="width: 120px;">No. Rujukan</th>
                    <th style="width: 100px;">No. Vesel</th>
                    <th style="width: 80px;">Zon</th>
                    <th>Nama Permohonan</th>
                    <th style="width: 120px;">Tarikh Permohonan</th>
                    <th style="width: 150px;">Status</th>
                    <th class="text-center" style="width: 80px;">Tindakan</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($appeals as $i => $app)
                @php
                    // Get reference number (No. Rujukan)
                    $refNumber = $app->ref_number ?? 'APP-' . str_pad($app->id, 6, '0', STR_PAD_LEFT);
                    
                    // Get application name based on type
                    $namaPermohonan = 'Lain-lain';
                    if ($app->perakuan) {
                        if ($app->perakuan->type === 'kvp07') {
                            $namaPermohonan = 'Permohonan Rayuan Pindaan Syarat';
                        } elseif ($app->perakuan->type === 'kvp08') {
                            $namaPermohonan = 'Permohonan Lanjut Tempoh Sah Kelulusan Perolehan';
                        }
                    }
                    
                    // Status configuration for different user roles
                    // Updated to use only green (positive) and red (negative) colors
                    $statusConfig = [
                        'submitted' => [
                            'ppl' => ['text' => 'Menunggu semakan', 'class' => 'success'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'success'], 
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'success'],
                            'applicant' => ['text' => 'Dihantar', 'class' => 'success']
                        ],
                        'ppl_review' => [
                            'ppl' => ['text' => 'Dalam semakan', 'class' => 'success'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'success'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'success'],
                            'applicant' => ['text' => 'Menunggu semakan', 'class' => 'success']
                        ],
                        'kcl_review' => [
                            'ppl' => ['text' => 'Selesai disemak', 'class' => 'success'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'success'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'success'],
                            'applicant' => ['text' => 'Menunggu sokongan', 'class' => 'success']
                        ],
                        'pk_review' => [
                            'ppl' => ['text' => 'Selesai disemak', 'class' => 'success'],
                            'kcl' => ['text' => 'Selesai disokong', 'class' => 'success'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'success'],
                            'applicant' => ['text' => 'Menunggu keputusan', 'class' => 'success']
                        ],
                        'ppl_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'danger']
                        ],
                        'kcl_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'danger']
                        ],
                        'pk_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'danger']
                        ],
                        'approved' => [
                            'all' => ['text' => 'Diluluskan', 'class' => 'success']
                        ],
                        'rejected' => [
                            'all' => ['text' => 'Tidak Diluluskan', 'class' => 'danger']
                        ]
                    ];
                    
                    // Determine user role type for status display
                    $roleType = 'applicant';
                    if (strpos($userRole, 'pegawai perikanan') !== false) {
                        $roleType = 'ppl';
                    } elseif (strpos($userRole, 'ketua cawangan') !== false) {
                        $roleType = 'kcl';  
                    } elseif (strpos($userRole, 'pengarah kanan') !== false) {
                        $roleType = 'pk';
                    }
                    
                    // Get status display
                    $statusDisplay = $statusConfig[$app->status][$roleType] ?? 
                                   $statusConfig[$app->status]['all'] ?? 
                                   ['text' => ucfirst(str_replace('_', ' ', $app->status)), 'class' => 'secondary'];
                @endphp
                
                <tr class="align-middle hover-row">
                    <td class="text-center text-muted">
                        @php
                            // Calculate days since application was received
                            $daysSinceReceived = $app->created_at->diffInDays(now());
                            $indicatorClass = '';
                            
                            if ($daysSinceReceived >= 10) {
                                $indicatorClass = 'dc3545'; // red
                            } elseif ($daysSinceReceived >= 5) {
                                $indicatorClass = 'ffc107'; // yellow
                            } else {
                                $indicatorClass = '6c757d'; // gray
                            }
                        @endphp
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="rounded-circle" style="width: 8px; height: 8px; background-color: #{{ $indicatorClass }};"></div>
                            {{ $i + 1 }}
                        </div>
                    </td>
                    
                    {{-- Unified View Columns --}}
                    <td class="fw-medium">{{ $refNumber }}</td>
                    <td>{{ $app->perakuan->no_vesel ?? 'V' . str_pad($app->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $app->perakuan->zon ?? 'C' }}</td>
                    <td>{{ $namaPermohonan }}</td>
                    <td>{{ $app->created_at ? $app->created_at->format('d/m/Y') : '-' }}</td>
                    <td>
                        @php
                            // New status format based on the image: "Pemohon → {{Tindakan}} Dihantar"
                            // For appeals, tindakan is always "Rayuan"
                            $tindakan = 'Rayuan'; // Since this is an appeals system
                            $applicantStatus = "Pemohon → {$tindakan} Dihantar";
                            
                            // Status colors remain the same
                            $statusColors = [
                                'submitted' => 'info',
                                'ppl_review' => 'info',
                                'kcl_review' => 'info',
                                'pk_review' => 'info',
                                'ppl_incomplete' => 'warning',
                                'kcl_incomplete' => 'warning',
                                'pk_incomplete' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'draft' => 'secondary'
                            ];
                            
                            $color = $statusColors[$app->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} text-white" style="border-radius: 4px;">
                            {{ $applicantStatus }}
                        </span>
                    </td>
                    <td class="text-center">
                        @php
                            $incompleteStatuses = ['ppl_incomplete', 'kcl_incomplete', 'pk_incomplete'];
                        @endphp
                        
                        @if(in_array($app->status, $incompleteStatuses))
                            <button type="button" 
                                    class="btn btn-sm" style="background-color: #dc3545; color: #fff; border: 1px solid #dc3545; border-radius: 4px;" 
                                    title="Edit/Kemaskini"
                                    onclick="window.location.href='{{ route('appeals.edit', ['id' => $app->id]) }}'">
                                <i class="fas fa-edit" style="color: #fff;"></i>
                            </button>
                        @elseif($app->status === 'approved')
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-sm" style="background-color: #0052af; color: #fff; border: 1px solid #0052af; border-radius: 4px;" 
                                        title="Lihat Status"
                                        onclick="handleTindakanClick('{{ $app->id }}')">
                                    <i class="fas fa-search" style="color: #fff;"></i>
                                </button>
                                <a href="{{ route('appeals.print_letter', $app->id) }}" 
                                   target="_blank"
                                   class="btn btn-sm" style="background-color: #5da5eb; color: #000; border: 1px solid #ddd; border-radius: 4px;" 
                                   title="Cetak Surat">
                                    <i class="fas fa-print" style="color: #000;"></i>
                                </a>
                                <a href="{{ route('appeals.download_letter_pdf', $app->id) }}" 
                                   class="btn btn-sm" style="background-color: #3cdccd; color: #000; border: 1px solid #ddd; border-radius: 4px;" 
                                   title="Muat Turun">
                                    <i class="fas fa-download" style="color: #000;"></i>
                                </a>
                            </div>
                        @else
                            <button type="button" 
                                    class="btn btn-sm" style="background-color: #0052af; color: #fff; border: 1px solid #0052af; border-radius: 4px;" 
                                    title="Lihat Status"
                                    onclick="handleTindakanClick('{{ $app->id }}')">
                                <i class="fas fa-search" style="color: #fff;"></i>
                            </button>
                        @endif
                    </td>
                </tr>
                
                {{-- Status Details Row (only for Pelesen) - Will be loaded via AJAX --}}
                @if(!$isOfficer)
                <tr id="status-details-{{ $app->id }}" class="status-details-row" style="display: none;">
                    <td colspan="5" class="p-0">
                        <div id="status-content-{{ $app->id }}" class="status-content-placeholder">
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mt-2 text-muted">Memuatkan status...</div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="{{ $isOfficer ? '9' : '6' }}" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i><br>
                        Tiada permohonan untuk dipaparkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
// Handle Tindakan button click - redirect to appropriate review page based on role
function handleTindakanClick(appealId) {
    console.log('Tindakan button clicked for appeal:', appealId);
    
    // Get user role from PHP
    const userRole = '{{ $userRole ?? "" }}';
    console.log('User role:', userRole);
    
    // Check for officer roles and redirect to their review pages
    if (userRole.includes('pegawai perikanan')) {
        // PPL Officer - redirect to PPL review page
        window.location.href = `{{ url('/appeals/ppl-review') }}/${appealId}`;
    } else if (userRole.includes('ketua cawangan')) {
        // KCL Officer - redirect to KCL review page
        window.location.href = `{{ url('/appeals/kcl-review') }}/${appealId}`;
    } else if (userRole.includes('pengarah kanan')) {
        // PK Officer - redirect to PK review page
        window.location.href = `{{ url('/appeals/pk-review') }}/${appealId}`;
    } else {
        // Applicant - redirect to status page
        window.location.href = `{{ url('/appeals') }}/${appealId}/status`;
    }
}
</script>
