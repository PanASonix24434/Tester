<div class="tab-pane fade" id="peralatan" role="tabpanel">
  <div class="card mb-4">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">{{ $tab['peralatan']['description'] }}</h4>
      </div>
    </div>

    <div class="card-body">
      <div class="table-responsive table-card">
        <table class="table text-nowrap mb-0 table-centered">
          <thead class="table-light">
            <tr>
              <th class="pe-0"></th>
              <th class="ps-0">Bil.</th>
              <th>Nama</th>
              <th>Jenis Peralatan</th>
              <th>Kuantiti/Panjang(m)</th>
              <th>Tarikh Alat Dilesenkan</th>
              <th>Status Peralatan</th>
            </tr>
          </thead>
          <tbody>
            @forelse($peralatan as $peralatan_item)
            <tr>
              <td class="pe-0"></td>
              <td class="ps-0">
                <a href="#">{{ $loop->iteration }}</a>
              </td>
              <td>{{ $peralatan_item->equipment_name ?? 'Tiada' }}</td>
              <td>
                @if($peralatan_item->equipment_type == 1)
                Utama
                @elseif($peralatan_item->equipment_type == 2)
                Tambahan
                @else
                Tiada
                @endif
              </td>
              <td>{{ $peralatan_item->quantity ?? 'Tiada' }}</td>
                <td>{{ $peralatan_item->date_licensed ? \Carbon\Carbon::parse($peralatan_item->date_licensed)->format('d-m-Y') : 'Tiada' }}</td>
              <td>{{ $peralatan_item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tiada maklumat tersedia.</td>
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