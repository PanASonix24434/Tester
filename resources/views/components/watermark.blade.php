{{-- Watermark Component --}}
<div class="watermark">
    <div class="watermark-text">JABATAN PERIKANAN MALAYSIA</div>
</div>

<style>
/* Watermark styles */
.watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 120px;
    font-weight: bold;
    color: rgba(0, 0, 0, 0.1);
    z-index: -1;
    pointer-events: none;
    user-select: none;
    white-space: nowrap;
}

.watermark-text {
    font-family: 'Times New Roman', serif;
    letter-spacing: 20px;
}

@media print {
    .watermark {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) rotate(-45deg) !important;
        font-size: 120px !important;
        font-weight: bold !important;
        color: rgba(0, 0, 0, 0.1) !important;
        z-index: -1 !important;
        pointer-events: none !important;
        user-select: none !important;
        white-space: nowrap !important;
    }
}
</style>
