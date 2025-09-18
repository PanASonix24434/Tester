<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lihat Dokumen - {{ $documentName ?? 'Dokumen' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .document-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 95%;
            min-height: 80vh;
        }
        .document-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .document-body {
            padding: 20px;
            min-height: 60vh;
        }
        .document-viewer {
            width: 100%;
            height: 70vh;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
        }
        .document-image {
            max-width: 100%;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .download-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
            text-decoration: none;
        }
        .back-btn {
            background: #6c757d;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        .error-message {
            text-align: center;
            padding: 40px;
            color: #dc3545;
        }
        .loading-spinner {
            text-align: center;
            padding: 40px;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="document-container">
            <div class="document-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">
                            <i class="fas fa-file-alt me-2"></i>
                            {{ $documentName ?? 'Dokumen' }}
                        </h4>
                        <small class="opacity-75">{{ $fileType ?? '' }}</small>
                    </div>
                    <div>
                        <a href="{{ $downloadUrl }}" class="download-btn" download>
                            <i class="fas fa-download"></i>
                            Muat Turun
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="document-body">
                @if($error)
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5>Ralat Memuat Dokumen</h5>
                        <p>{{ $error }}</p>
                        <a href="javascript:history.back()" class="back-btn">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                @else
                    <div id="document-content">
                        <div class="loading-spinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Memuatkan...</span>
                            </div>
                            <p class="mt-3">Memuatkan dokumen...</p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="javascript:history.back()" class="back-btn me-3">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a href="{{ $downloadUrl }}" class="download-btn" download>
                            <i class="fas fa-download"></i>
                            Muat Turun
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const documentContent = document.getElementById('document-content');
            const fileUrl = '{{ $fileUrl }}';
            const fileExtension = '{{ $fileExtension }}';
            
            if (documentContent && fileUrl) {
                loadDocument(fileUrl, fileExtension, documentContent);
            }
        });

        function loadDocument(url, extension, container) {
            const lowerExt = extension.toLowerCase();
            
            // Hide loading spinner
            container.innerHTML = '';
            
            if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(lowerExt)) {
                // Display image
                const img = document.createElement('img');
                img.src = url;
                img.className = 'document-image';
                img.alt = 'Dokumen';
                img.onload = function() {
                    container.appendChild(img);
                };
                img.onerror = function() {
                    showError(container, 'Tidak dapat memuatkan imej dokumen.');
                };
            } else if (lowerExt === 'pdf') {
                // Display PDF in iframe
                const iframe = document.createElement('iframe');
                iframe.src = url + '#toolbar=1&navpanes=1&scrollbar=1';
                iframe.className = 'document-viewer';
                iframe.onload = function() {
                    container.appendChild(iframe);
                };
                iframe.onerror = function() {
                    showError(container, 'Tidak dapat memuatkan PDF dokumen.');
                };
            } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(lowerExt)) {
                // For Office documents, try to open with Google Docs viewer
                const iframe = document.createElement('iframe');
                iframe.src = 'https://docs.google.com/gview?url=' + encodeURIComponent(url) + '&embedded=true';
                iframe.className = 'document-viewer';
                iframe.onload = function() {
                    container.appendChild(iframe);
                };
                iframe.onerror = function() {
                    showError(container, 'Tidak dapat memuatkan dokumen Office. Sila muat turun untuk melihat dokumen.');
                };
            } else {
                // For other file types, show download option
                showError(container, 'Format dokumen tidak disokong untuk paparan dalam talian. Sila muat turun untuk melihat dokumen.');
            }
        }

        function showError(container, message) {
            container.innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3 text-warning"></i>
                    <h6>${message}</h6>
                </div>
            `;
        }
    </script>
</body>
</html>
