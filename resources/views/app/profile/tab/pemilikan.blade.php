<div class="tab-pane fade" id="pemilikan" role="tabpanel">
  <div class="card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">{{ $tab['pemilikan']['description'] }}</h4>
      </div>
    </div>
    
    <div class="card-body">
      <div class="table-responsive table-card">
        <table class="table text-nowrap mb-0 table-centered">
          <thead class="table-light">
            <tr>
              <th class="pe-0"></th>
              <th class="ps-0">Bil.</th>
              <th>Nama Pemilik</th>
              <th>No. Kad Pengenalan/No. Pendaftaran Syarikat </th>
              <th>Jenis Pemilikan</th>
              <th>Negeri</th>
              <th>Daerah</th>
              <th>Tarikh Aktif Pemilikan</th>
              <th>Status Aktif</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pemilikan as $pemilikan_item)
            <tr>
              <td class="pe-0"></td>
              <td class="ps-0">
                <a href="#">{{ $loop->iteration }}</a>
              </td>
              <td>{{ $pemilikan_item->nama_pemilik ?? 'Tiada' }}</td>
              <td>{{ $pemilikan_item->no_ic_atau_syarikat ?? 'Tiada' }}</td>
              <td>{{ $pemilikan_item->jenis_pemilikan ?? 'Tiada' }}</td>
              <td>{{ $pemilikan_item->negeri ?? 'Tiada' }}</td>
              <td>{{ $pemilikan_item->daerah ?? 'Tiada' }}</td>
                <td>{{ $pemilikan_item->tarikh_aktif_pemilikan ? \Carbon\Carbon::parse($pemilikan_item->tarikh_aktif_pemilikan)->format('d-m-Y') : 'Tiada' }}</td>
              <!-- <td>{{ $pemilikan_item->status_pemilikan ?? 'Tiada' }}</td> -->
              @php
                  if ( $pemilikan_item->status_pemilikan === 'Aktif') {
                      $badgeClass = 'badge-success-soft text-dark-success';
                      $statusText = 'Aktif';
                  } elseif ( $pemilikan_item->status_pemilikan === 'Tidak Aktif') {
                      $badgeClass = 'badge-warning-soft text-dark-warning';
                      $statusText = 'Tidak Aktif';
                  } else {
                      $badgeClass = 'badge-danger-soft text-dark-danger';
                      $statusText = 'Batal';
                  }
              @endphp

              <td>
                  <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">Tiada maklumat tersedia.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-center mt-2">
      <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">Kembali <i class="icon-xxs"></i></a>
    </div>
  </div>
</div>
