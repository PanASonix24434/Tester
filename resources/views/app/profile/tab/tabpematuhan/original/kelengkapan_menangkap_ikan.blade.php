<div class="tab-pane fade show active" id="kelengkapan_menangkap_ikan" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Kelengkapan Menangkap Ikan</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>Echo Sounder :</td>
                        <td>{{ $pematuhan->has_echo_sounder ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Sonar :</td>
                        <td>{{ $pematuhan->has_sonar ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Net Hauler :</td>
                        <td>{{ $pematuhan->has_hauler ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Power Block :</td>
                        <td>{{ $pematuhan->has_power_block ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>Petak Ikan :</td>
                        <td>{{ $pematuhan->has_fish_hold ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                    <tr>
                        <td>RSW :</td>
                        <td>{{ $pematuhan->has_rsw ? 'Ada' : 'Tiada' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
