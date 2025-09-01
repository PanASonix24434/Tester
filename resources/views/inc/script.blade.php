<!-- jQuery -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>

<!-- =============================================================================================== -->

<!-- Scripts -->
<!-- Libs JS -->

<!-- Color modes -->
{{-- <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script> --}}

<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script> --}}
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Theme JS -->
<script src="{{ asset('assets/js/theme.min.js') }}"></script>

<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/chart.js') }}"></script>

<script type="text/javascript">
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 bs4 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>
