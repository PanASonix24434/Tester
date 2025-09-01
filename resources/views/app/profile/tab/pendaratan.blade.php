<div class="tab-pane fade" id="pendaratan" role="tabpanel">
    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $tab['pendaratan']['description'] }}</h4>
                </div>
                <br>

               
                    <div class="mb-4 text-left">  
                    <a href="{{ route('profile.pilihCara', $vessel->id) }}" class="btn btn-primary btn-sm"><span class="hidden-xs"> Tambah</span></a>

                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
               
                

                <div class="table-responsive">
                    <table class="table table-centered text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Bil.</th>
                                <th scope="col">Pelayaran No.</th>
                                <th scope="col">Bagi Bulan</th> 
                                <th scope="col">Jumlah Hari di Laut</th>
                                <th scope="col">Tarikh & Masa (Berlepas)</th>
                                <th scope="col">Tarikh & Masa (Balik/Tiba)</th>
                                <th scope="col">Purata Masa Sekali Memukat</th>
                                <th scope="col">Dokumen</th> 
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaratan as $pendaratan_item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pendaratan_item->pelayaran_no ?? 'Tiada' }}</td>
                                    <td>{{ $pendaratan_item->bulan ?? 'Tiada' }}</td>
                                    <td>{{ $pendaratan_item->jumlah_hari_di_laut ?? 'Tiada' }}</td>
                                    <td>{{isset($pendaratan_item->tarikh_masa_berlepas)  ? \Carbon\Carbon::parse($pendaratan_item->tarikh)->format('d-m-Y H:i') : 'Tiada' }}</td>
                                    <td>{{ isset($pendaratan_item->tarikh_masa_tiba ) ? \Carbon\Carbon::parse($pendaratan_item->tarikh)->format('d-m-Y H:i') : 'Tiada' }}</td>
                                    <td>{{ $pendaratan_item->purata_masa_memukat ?? 'Tiada' }}</td>
                                    <td>{{ $pendaratan_item->dokumen_nama ?? 'Tiada' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tiada Rekod</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="javascript:history.back()" class="btn btn-outline-white btn-sm me-2">
                        Kembali <i class="icon-xxs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
