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
                    <th style="width: 140px;">No. Rujukan</th>
                    <th>Nama Permohonan</th>
                    <th style="width: 150px;">Nama Pemohon</th>
                    <th style="width: 100px;">Negeri</th>
                    <th style="width: 100px;">Daerah</th>
                    <th style="width: 140px;">Tarikh Kemaskini</th>
                    <th style="width: 120px;">Status Permohonan</th>
                    <th style="width: 100px;">Tempoh Pegangan</th>
                    <th class="text-center" style="width: 80px;">Tindakan</th>
                @else
                    {{-- Applicant view columns --}}
                    <th>No. Rujukan</th>
                    <th>Nama Permohonan</th>
                    <th>Tarikh Kemaskini</th>
                    <th>Status Permohonan</th>
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
                    <td class="text-center text-muted">{{ $i + 1 }}</td>
                    
                    @if($isOfficer)
                        {{-- Officer View Columns --}}
                        <td class="fw-medium">{{ $refNumber }}</td>
                        <td>{{ $namaPermohonan }}</td>
                        <td>{{ $app->applicant->name ?? $app->applicant->username ?? '-' }}</td>
                        <td>{{ $app->perakuan->negeri_limbungan_baru ?? auth()->user()->state_id ?? '-' }}</td>
                        <td>{{ $app->perakuan->daerah_baru ?? auth()->user()->district ?? '-' }}</td>
                        <td>{{ $app->updated_at ? $app->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $statusDisplay['class'] }} text-white">
                                {{ $statusDisplay['text'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                // Calculate days since application was received
                                $daysSinceReceived = $app->created_at->diffInDays(now());
                                $indicatorClass = '';
                                $indicatorText = $daysSinceReceived . ' hari';
                                
                                if ($daysSinceReceived >= 10) {
                                    $indicatorClass = 'bg-danger text-white';
                                } elseif ($daysSinceReceived >= 5) {
                                    $indicatorClass = 'bg-warning text-dark';
                                } else {
                                    $indicatorClass = 'bg-success text-white';
                                }
                            @endphp
                            <span class="badge {{ $indicatorClass }}">
                                {{ $indicatorText }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 4px;" 
                                    title="Lihat Permohonan"
                                    onclick="handleTindakanClick('{{ $app->id }}')">
                                <i class="fas fa-search" style="color: #fff;"></i>
                            </button>
                        </td>
                    @else
                        {{-- Applicant View Columns for KPV-07/KPV-08 --}}
                        <td class="fw-medium">{{ $refNumber }}</td>
                        <td>{{ $namaPermohonan }}</td>
                        <td>{{ $app->updated_at ? $app->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @php
                                // Applicant-specific status configuration for KPV-07/KPV-08
                                // Updated to use only green (positive) and red (negative) colors
                                $applicantStatusConfig = [
                                    'submitted' => ['text' => 'Dihantar', 'class' => 'success'],
                                    'ppl_review' => ['text' => 'Menunggu semakan', 'class' => 'success'],
                                    'kcl_review' => ['text' => 'Menunggu sokongan', 'class' => 'success'],
                                    'pk_review' => ['text' => 'Menunggu keputusan', 'class' => 'success'],
                                    'ppl_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'danger'],
                                    'kcl_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'danger'],
                                    'pk_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'danger'],
                                    'approved' => ['text' => 'Diluluskan', 'class' => 'success'],
                                    'rejected' => ['text' => 'Tidak Diluluskan', 'class' => 'danger'],
                                    'draft' => ['text' => 'Draft', 'class' => 'success']
                                ];
                                
                                $applicantStatus = $applicantStatusConfig[$app->status] ?? 
                                                 ['text' => ucfirst(str_replace('_', ' ', $app->status)), 'class' => 'secondary'];
                            @endphp
                            <span class="badge bg-{{ $applicantStatus['class'] }} text-white">
                                {{ $applicantStatus['text'] }}
                            </span>
                        </td>
                        <td class="text-center">
                                    @php
                                        $incompleteStatuses = ['ppl_incomplete', 'kcl_incomplete', 'pk_incomplete'];
                                        // Check if pin number exists for this application
                                        $pinNumber = null;
                                        if ($app->perakuan && $app->perakuan->pin_number) {
                                            $pinNumber = $app->perakuan->pin_number;
                                        }
                                    @endphp
                                    
                                    @if($pinNumber)
                                        <div class="mb-2">
                                            <span class="badge bg-info text-white" title="Nombor Pin">
                                                PIN: {{ $pinNumber }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if(in_array($app->status, $incompleteStatuses))
                                <a href="{{ route('appeals.edit', ['id' => $app->id]) }}" 
                                   class="btn btn-sm btn-warning border shadow-sm" title="Edit/Kemaskini">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @elseif($app->status === 'approved')
                                {{-- Show print button for approved applications --}}
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 4px;" 
                                            title="Lihat Status"
                                            onclick="handleTindakanClick('{{ $app->id }}')">
                                        <i class="fas fa-search" style="color: #fff;"></i>
                                    </button>
                                    <a href="{{ route('appeals.print_letter', $app->id) }}" 
                                       target="_blank"
                                       class="btn btn-sm" style="background-color: #1A73E8; color: #000; border: 1px solid #ddd; border-radius: 6px;" 
                                       title="Cetak Surat">
                                        <i class="fas fa-print" style="color: #000;"></i>
                                    </a>
                                      <a href="{{ route('appeals.download_letter_pdf', $app->id) }}" 
                                        class="btn btn-sm" style="background-color: #17A2B8; color: #000; border: 1px solid #ddd; border-radius: 6px; display: flex; align-items: center; gap: 8px;" 
                                        title="Muat Turun">
                                         <i class="fas fa-download" style="color: #000;"></i>
                                      </a>
                                </div>
                            @else
                                <button type="button" 
                                        class="btn btn-sm" style="background-color: #007BFF; color: #fff; border: 1px solid #007BFF; border-radius: 4px;" 
                                        title="Lihat Status"
                                        onclick="handleTindakanClick('{{ $app->id }}')">
                                    <i class="fas fa-search" style="color: #fff;"></i>
                                </button>
                            @endif
                        </td>
                    @endif
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
// Handle Tindakan button click with role validation
function handleTindakanClick(appealId) {
    console.log('Tindakan button clicked for appeal:', appealId);
    
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i>';
    button.disabled = true;
    
    // Call role validation API
    fetch(`{{ url('/appeals/validate-tindakan') }}/${appealId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Role validation response:', data);
            
            if (data.success) {
                if (data.action === 'status_content') {
                    // Show status content for pelesen
                    loadStatusDetails(appealId);
                } else if (data.action === 'redirect') {
                    // Redirect to appropriate review page
                    window.location.href = data.redirect_url;
                }
            } else {
                // Handle error
                alert('Error: ' + data.message);
                console.error('Role validation error:', data);
            }
        })
        .catch(error => {
            console.error('Error validating role:', error);
            alert('Ralat memvalidasi peranan pengguna.');
        })
        .finally(() => {
            // Restore button state
            button.innerHTML = originalContent;
            button.disabled = false;
        });
}

function loadStatusDetails(appealId) {
    const statusRow = document.getElementById('status-details-' + appealId);
    const statusContent = document.getElementById('status-content-' + appealId);
    
    if (statusRow) {
        if (statusRow.style.display === 'none') {
            // Hide all other status details first
            document.querySelectorAll('.status-details-row').forEach(row => {
                row.style.display = 'none';
            });
            
            // Show the selected one
            statusRow.style.display = 'table-row';
            
            // Load status content via AJAX if not already loaded
            if (!statusContent.dataset.loaded) {
                fetch(`{{ url('/appeals') }}/${appealId}/status-content`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(html => {
                        statusContent.innerHTML = html;
                        statusContent.dataset.loaded = 'true';
                    })
                    .catch(error => {
                        console.error('Error loading status:', error);
                        statusContent.innerHTML = `
                            <div class="text-center p-4 text-danger">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                <div>Ralat memuatkan status permohonan.</div>
                                <small class="text-muted">Error: ${error.message}</small>
                            </div>
                        `;
                    });
            }
        } else {
            // Hide the current one
            statusRow.style.display = 'none';
        }
    }
}
</script>
