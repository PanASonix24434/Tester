<div class="tab-pane fade" id="lesen" role="tabpanel">
  <div class="card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">{{ $tab['lesen']['description'] }}</h4>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive table-card">
        <table class="table text-nowrap mb-0 table-centered">
          <thead class="table-light">
            <tr>
              <th class="pe-0"></th>
              <th class="ps-0">Bil.</th>
              <th>No. Lesen</th>
              <th>Tarikh Mula Lesen</th>
              <th>Tarikh Tamat Lesen</th>
              <th>Zon</th>
              <th>Kawasan Perairan</th>
              <th>No. Patil</th>
              <th>Status Lesen</th>
              <th>Status IUU</th>
              @if( $user -> user_type == 3)
              <th>No. Lesen SKL</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @forelse($lesen as $lesen_item)
            <tr>
              <td class="pe-0"></td>
              <td class="ps-0">
                <a href="#">{{ $loop->iteration }}</a>
              </td>
              <td>
                <span class="badge badge-warning-soft text-warning">
                  {{ $lesen_item->no_lesen ?? 'Tiada' }}
                </span>
              </td>
                <td>{{ $lesen_item->tarikh_keluar ? \Carbon\Carbon::parse($lesen_item->tarikh_keluar)->format('d-m-Y') : 'Tiada' }}</td>
                <td>{{ $lesen_item->tarikh_tamat ? \Carbon\Carbon::parse($lesen_item->tarikh_tamat)->format('d-m-Y') : 'Tiada' }}</td>
              <td>{{ $lesen_item->kod_zon ?? 'Tiada' }}</td>
              <td>{{ $lesen_item->kawasan_perairan ?? 'Tiada' }}</td>
              <td>{{ $lesen_item->no_patil ?? 'Tiada' }}</td>
              
              @php
                  if ($lesen_item->status_lesen === 'Aktif') {
                      $badgeClass = 'badge-success-soft text-dark-success';
                      $statusText = 'Aktif';
                  } elseif ($lesen_item->status_lesen === 'Tidak Aktif') {
                      $badgeClass = 'badge-warning-soft text-dark-warning';
                      $statusText = 'Tidak Aktif';
                  } else {
                      $badgeClass = 'badge-danger-soft text-dark-danger';
                      $statusText = 'Batal';
                  }
              @endphp

              <td><span class="badge {{ $badgeClass }}">
                  {{ $statusText }}
              </span></td>

              @php
                switch ($am_vessel->status_iuu) {
                    case 1:
                        $badgeClass = 'badge-success-soft text-dark-success';
                        $statusIUU = 'Ada';
                        break;

                    case 0:
                        $badgeClass = 'badge-danger-soft text-dark-danger';
                        $statusIUU = 'Tiada';
                        break;

                    default:
                        $badgeClass = 'badge-secondary';
                        $statusIUU = 'Tidak Diketahui';
                        break;
                }
            @endphp

            <td>
                <span class="badge {{ $badgeClass }}">
                    {{ $statusIUU }}
                </span>
            </td>


              @if( $user -> user_type == 3)
              <td>{{ $lesen_item->no_lesen_skl ?? 'Tiada' }}</td>
              @endif
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center">Tiada maklumat tersedia.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-center mt-2">
      <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
        Kembali <i class="icon-xxs"></i>
      </a>
    </div>
  </div>
</div>