<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-M8S4MT3EYG"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-M8S4MT3EYG');
        </script>

        <!-- Favicon icon-->
        <link rel="shortcut icon" type="image/x-icon" href="./assets/images/favicon/favicon.ico" />

        <!-- Color modes -->
        <script src="./assets/js/vendors/color-modes.js"></script>

        @include('layouts.style')
        @stack('styles')

		<title>Sistem e-Lesen 2.0</title>
	</head>

	<body>

        <main id="main-wrapper" class="main-wrapper">
			<!-- header -->
            @include('layouts.header')

			<!-- header -->
            @include('layouts.sidebar')

            <!-- Content -->
            @yield('content')

            <!-- Delete Modal -->
            @include('layouts.delete_modal')

		</main>

        @include('layouts.script')
        @stack('scripts')

        <script>
            $(function () {

              //delete modal
              $('#delete-modal').on("show.bs.modal", function (event) {
                    $(this).find('#delete-form').attr('action', $(event.relatedTarget).data('href'));
                    $(this).find('.modal-text').text($(event.relatedTarget).data('text'));
              });

              //Initialize Select2 Elements
              $('select').select2();
          
              //Initialize Select2 Elements
              $('.select2bs4').select2({
                theme: 'bootstrap4'
              })
          
            });
          
        </script>

    <script>
        function updateDateTime() {
        moment.locale('ms-my'); // Set locale to Bahasa Melayu

        var now = moment();
        var formattedDate = now.format('dddd, D MMMM YYYY'); // Example: Isnin, 10 September 2024
        var formattedTime = now.format('h:mm:ss A'); // Example: 3:45:12 PTG

        document.getElementById('datetime').innerHTML = formattedDate + ' | ' + formattedTime;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call to avoid delay
    </script>
		
	</body>
</html>
