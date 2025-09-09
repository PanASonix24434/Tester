<!-- Key In Status Permohonan Tab Content -->
<div class="row">
    <div class="col-12">
        <h5>Status Terkini Permohonan</h5>
        
        <!-- Status Timeline -->
        <div class="card">
            <div class="card-body">
                <div class="timeline">
                    <!-- First Event -->
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="timeline-title">10 Oct 2024</h6>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="timeline-time">14:11</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-body">
                                <div class="mb-2">
                                    <span class="badge badge-success">PERMOHONAN DIHANTAR</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Ulasan :</label>
                                    <input type="text" class="form-control" value="-" readonly>
                                </div>
                                <div class="timeline-actions">
                                    <a href="#" class="btn btn-link btn-sm">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Event -->
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="timeline-title">14 Oct 2024</h6>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span class="timeline-time">14:11</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-body">
                                <div class="mb-2">
                                    <span class="badge badge-success">PERMOHONAN DISEMAK</span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Ulasan :</label>
                                    <textarea class="form-control" rows="4" readonly>Permohonan ini telah disemak dan memenuhi semua kriteria yang ditetapkan. Kami mengesyorkan agar ia diteruskan ke peringkat seterusnya. Semua dokumen yang diperlukan telah disertakan dengan lengkap dan teratur. Jika ada sebarang pertanyaan atau keperluan untuk penjelasan lanjut, sila hubungi pihak kami.</textarea>
                                </div>
                                <div class="timeline-actions">
                                    <a href="#" class="btn btn-link btn-sm">View More</a>
                                    <a href="#" class="btn btn-link btn-sm">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline End -->
                    <div class="timeline-item">
                        <div class="timeline-marker bg-light"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-header {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f8f9fa;
}

.timeline-title {
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.timeline-time {
    color: #6c757d;
    font-size: 0.9em;
}

.timeline-body {
    margin-bottom: 15px;
}

.timeline-actions {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #f8f9fa;
}

.timeline-actions .btn-link {
    color: #007bff;
    text-decoration: none;
    margin-right: 15px;
}

.timeline-actions .btn-link:hover {
    text-decoration: underline;
}

.badge-success {
    background-color: #28a745;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.85em;
    font-weight: 500;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 5px;
}

.form-control[readonly] {
    background-color: #f8f9fa;
    border-color: #e9ecef;
}
</style>
