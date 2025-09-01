<div class="tab-pane fade show active" id="dokumen" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">Maklumat Dokumen</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>General Arrangement :</td>
                        <td>
                            @if($pematuhan->general_arrangement_path)
                                <a href="{{ asset('storage/' . $pematuhan->general_arrangement_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Vessel Marking :</td>
                        <td>
                            @if($pematuhan->vessel_certificate_path)
                                <a href="{{ asset('storage/' . $pematuhan->vessel_certificate_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Laporan Pemeriksaan - Kejuruteraan :</td>
                        <td>
                            @if($pematuhan->engineering_inspection_path)
                                <a href="{{ asset('storage/' . $pematuhan->engineering_inspection_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Laporan Pemeriksaan - Surveyor :</td>
                        <td>
                            @if($pematuhan->sureveyor_inspections_path)
                                <a href="{{ asset('storage/' . $pematuhan->sureveyor_inspections_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Certificate of Registration :</td>
                        <td>
                            @if($pematuhan->cert_of_reg_path)
                                <a href="{{ asset('storage/' . $pematuhan->cert_of_reg_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Gear Making :</td>
                        <td>
                            @if($pematuhan->gear_making_path)
                                <a href="{{ asset('storage/' . $pematuhan->gear_making_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Hygeine on Board :</td>
                        <td>
                            @if($pematuhan->hygiene_path)
                                <a href="{{ asset('storage/' . $pematuhan->hygiene_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>International Oil Pollution Prevention Cert :</td>
                        <td>
                            @if($pematuhan->international_oil_pollution_path)
                                <a href="{{ asset('storage/' . $pematuhan->international_oil_pollution_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>International Tonnage Cert :</td>
                        <td>
                            @if($pematuhan->international_tonnage_certificate_path)
                                <a href="{{ asset('storage/' . $pematuhan->international_tonnage_certificate_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Sijil Kompetensi Kakitangan :</td>
                        <td>
                            @if($pematuhan->staff_competency_cert_path)
                                <a href="{{ asset('storage/' . $pematuhan->staff_competency_cert_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Sijil Peralatan Keselamatan :</td>
                        <td>
                            @if($pematuhan->safety_equipment_cert_path)
                                <a href="{{ asset('storage/' . $pematuhan->safety_equipment_cert_path) }}" target="_blank">Lihat Dokumen</a>
                            @else
                                Tiada Dokumen
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
