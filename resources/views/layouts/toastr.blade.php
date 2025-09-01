<link rel="stylesheet" type="text/css" href="{{ asset('template/plugins/toastr/toastr.min.css') }}">
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        toastr.options = {
            "escapeHtml": false,
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @foreach (['t_success', 't_info', 't_warning', 't_error'] as $key)
            @if (session()->has($key))
                toastr["{{ ltrim($key, 't_') }}"]("{!! session()->get($key) !!}");
            @endif
        @endforeach
    });
</script>