<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('layouts.page_title')
        <title>{{ config('app.name', 'Laravel 2') }}</title>
        <link rel="icon" href="{{ asset('images/doflogoonly.png') }}" type="image/png">

        @include('layouts.style')
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- show password -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        @stack('styles')
        <style type="text/css">
            .form-control.is-invalid {
                border-color: #dc3545 !important;
            }
        </style>
    </head>
    <body class="hold-transition login-page" style="background: linear-gradient(rgba(192, 192, 192, 0.8) 0%, rgba(0, 128, 128, 0.8) 100%), url('{{asset ('/images/bg-elesen.jpg') }}');" >
        <div style="position:absolute;top:20px;right:20px;">
            @include('layouts.language')
        </div>
        <br><br>
        <div class="login-box">
            <div class="card">
                @yield('content')
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- /.login-box -->
    
        @include('layouts.script')
        @stack('scripts')
        <script type="text/javascript">
            $(function () {
                $('#lang').change(function () {
                    
                    if ($('#lang').val() == 'ms') {
                        window.location = "{{ url('lang/ms') }}";
                    }

                    if ($('#lang').val() == 'en') {
                        window.location = "{{ url('lang/en') }}";
                    }
                    
                });
                $('input').focus(function () {
                    $(this).removeClass('is-invalid');
                    $(this).next('span.text-danger').empty();
                    $(this).parent('div').next('span.text-danger').empty();
                });
            });
        </script>
    </body>
</html>