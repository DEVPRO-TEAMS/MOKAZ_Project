
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="fr-FR">

    <head>
        <meta charset="utf-8">
        <title>MOKAZ - Plateforme Immobilier</title>

        <meta name="author" content="themesflat.com">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- font -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
        <!-- Icons -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/font-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">


        <link rel="stylesheet" href="{{ asset('assets/css/apexcharts.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet"type="text/css" href="{{ asset('assets/css/styles.css') }}" />
        <link rel="stylesheet"type="text/css" href="{{ asset('assets/css/custom.css') }}" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

        <!-- Favicon and Touch Icons  -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/images/logo/favicon.png') }}">


    </head>

    <body class="body bg-surface counter-scroll">

        <div class="preload preload-container">
            <div class="boxes ">
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="box">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>

        <!-- /preload -->

        <div id="wrapper" class="wrapper">
            <div id="page" class="clearfix">
                <div class="layout-wrap">
                    <!-- sidebar dashboard -->
                    @include('layouts.sidbar')
                    <!-- end sidebar dashboard -->
                    <div class="container-fluid" style="margin-top: 6%">
                        <div class="main-content">
                            @yield('content')
                        </div>
                        <div class="footer-dashboard">
                            <p class="text-variant-2">©2025 MOKAZ. Tous droits réservés.</p>
                        </div>
                    </div>
                    <div class="overlay-dashboard"></div>
                </div>
            </div>
        </div>

        <!-- /#page -->
        
        <!-- go top -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                    style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
                </path>
            </svg>
        </div>

        <!-- Javascript -->

        <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/2b6a213e82.js" crossorigin="anonymous"></script>

         <!-- JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/carousel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/plugin.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/chart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/chart-init.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/rangle-slider.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/countto.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/tinymce/tinymce.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/tinymce/tinymce-custom.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/shortcodes.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jqueryui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/animation_heading.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <script type="text/javascript" src="{{ asset('assets/js/owl.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFC3m2n0jBRFTMvUNZc0-6Y0Rzlcadzcw"></script>
        <script src="{{ asset('assets/js/map-single.js')}}"></script>
        <script src="{{ asset('assets/js/map.js') }}"></script>
        <script src="{{ asset('assets/js/map-contact.js') }}"></script>
        <script src="{{ asset('assets/js/marker.js') }}"></script>
        <script src="{{ asset('assets/js/infobox.min.js') }}"></script>

        <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

        <script>
             $(document).ready(function() {
    

                var table = $('#example2').DataTable({
                    lengthChange: true,
                    searching: false,
                    buttons: ['copy', 'excel', 'pdf', 'print'],
                    language: {
                                search: "Recherche :",
                                lengthMenu: "Afficher _MENU_ lignes",
                                zeroRecords: "Aucun enregistrement trouvé",
                                info: "Affichage de _START_ à _END_ sur _TOTAL_ enregistrements",
                                infoEmpty: "Aucun enregistrement disponible",
                                infoFiltered: "(filtré à partir de _MAX_ enregistrements)",
                                paginate: {
                                    first: "Premier",
                                    last: "Dernier",
                                    next: "Suivant",
                                    previous: "Précédent",
                                },
                            },
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });
        </script>

    </body>

</html>
