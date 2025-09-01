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
                    $statusConfig = [
                        'submitted' => [
                            'ppl' => ['text' => 'Menunggu semakan', 'class' => 'warning'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'warning'], 
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'warning'],
                            'applicant' => ['text' => 'Dihantar', 'class' => 'primary']
                        ],
                        'ppl_review' => [
                            'ppl' => ['text' => 'Dalam semakan', 'class' => 'info'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'warning'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'warning'],
                            'applicant' => ['text' => 'Menunggu semakan', 'class' => 'primary']
                        ],
                        'kcl_review' => [
                            'ppl' => ['text' => 'Selesai disemak', 'class' => 'success'],
                            'kcl' => ['text' => 'Menunggu sokongan', 'class' => 'warning'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'warning'],
                            'applicant' => ['text' => 'Menunggu sokongan', 'class' => 'primary']
                        ],
                        'pk_review' => [
                            'ppl' => ['text' => 'Selesai disemak', 'class' => 'success'],
                            'kcl' => ['text' => 'Selesai disokong', 'class' => 'success'],
                            'pk' => ['text' => 'Menunggu keputusan', 'class' => 'warning'],
                            'applicant' => ['text' => 'Menunggu keputusan', 'class' => 'primary']
                        ],
                        'ppl_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'warning']
                        ],
                        'kcl_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'warning']
                        ],
                        'pk_incomplete' => [
                            'all' => ['text' => 'Perlu dikemaskini', 'class' => 'warning']
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
                            <a href="{{ route('appeals.role_review', ['id' => $app->id]) }}" 
                               class="btn btn-sm btn-light border shadow-sm" title="Lihat Permohonan">
                                <i class="fas fa-eye text-primary"></i>
                            </a>
                        </td>
                    @else
                        {{-- Applicant View Columns for KPV-07/KPV-08 --}}
                        <td class="fw-medium">{{ $refNumber }}</td>
                        <td>{{ $namaPermohonan }}</td>
                        <td>{{ $app->updated_at ? $app->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @php
                                // Applicant-specific status configuration for KPV-07/KPV-08
                                $applicantStatusConfig = [
                                    'submitted' => ['text' => 'Dihantar', 'class' => 'primary'],
                                    'ppl_review' => ['text' => 'Menunggu semakan', 'class' => 'primary'],
                                    'kcl_review' => ['text' => 'Menunggu sokongan', 'class' => 'primary'],
                                    'pk_review' => ['text' => 'Menunggu keputusan', 'class' => 'primary'],
                                    'ppl_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'warning'],
                                    'kcl_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'warning'],
                                    'pk_incomplete' => ['text' => 'Perlu dikemaskini', 'class' => 'warning'],
                                    'approved' => ['text' => 'Diluluskan', 'class' => 'success'],
                                    'rejected' => ['text' => 'Tidak Diluluskan', 'class' => 'danger'],
                                    'draft' => ['text' => 'Draft', 'class' => 'secondary']
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
                            @endphp
                            @if(in_array($app->status, $incompleteStatuses))
                                <a href="{{ route('appeals.edit', ['id' => $app->id]) }}" 
                                   class="btn btn-sm btn-warning border shadow-sm" title="Edit/Kemaskini">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @else
                                <a href="{{ route('appeals.role_review', ['id' => $app->id]) }}" 
                                   class="btn btn-sm btn-light border shadow-sm" title="Lihat">
                                    <i class="fas fa-pencil text-primary"></i>
                                </a>
                            @endif
                        </td>
                    @endif
                </tr>
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
