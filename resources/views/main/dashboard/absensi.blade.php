<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="aGL9mgKAjitF0e3BQVfxLGjyunp6mtfBGqik1DZZ" />
    <title>Sistem Absensi - KPU Kabupaten Ngada</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />

    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    @stack('css')
</head>

<body>

    <div class="row pt-4">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-center text-white">Silahkan scan barcode kamu disini!</h3>
                </div>
                <div class="card-body">
                    <div id="reader" width="600px"></div>
                </div>
                <div class="card-footer text-center bg-success" hidden></div>
            </div>
        </div>

        {{-- <div class="col-6 mx-auto text-center" id="test"></div> --}}
    </div>

    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function updateQrLogDB() {
            setInterval(() => {
                $.get("/update/log-qr", function(data) {
                    console.log(data);
                });
            }, 30000);
        }

        // function configDB() {
        //     $.get("/config/database", function(data) {
        //         var formattedTime = new Intl.DateTimeFormat('en-US', {
        //             timeStyle: 'medium',
        //             hour12: false
        //         }).format(new Date());

        //         if(formattedTime > data.jam_masuk.batas_akhir && formattedTime) {
        //             toastr["warning"]('Batas absen masuk melebihi waktu yang ditentukan')
        //         }
        //     });
        // }

        $(document).ready(function() {
            updateQrLogDB();

            setTimeout(() => {
                $('#html5-qrcode-button-camera-stop').prop('hidden', true)
            }, 1500);

            function onScanSuccess(decodedText, decodedResult) {
                console.log(decodedText)
                // handle the scanned code as you like, for example:
                $.get("/staff/absensi/store/" + decodedText, function(data) {
                    if (data.status == 200) {
                        $('.card-footer').empty();
                        $('.card-footer').append('<h4 class="text-white">' + data.message + '</h4>')
                        $('.card-footer').prop('hidden', false)
                    } else {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": true,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr["error"](data.message)
                    }
                });
            }

            // FORMAT TIME
            var formattedTime = new Intl.DateTimeFormat('en-US', {
                timeStyle: 'medium',
                hour12: false
            }).format(new Date());

            var data = {
                jam_masuk: {
                    batas_awal: "16:00",
                    batas_akhir: "17:00:00"
                },
                jam_keluar: {
                    batas_awal: "20:00",
                    batas_akhir: "22:59:59"
                }
            };

            if (formattedTime > "{{$jamMasuk_akhir}}" && formattedTime < "{{$jamKeluar_awal}}") {
                $('.card-header').empty()
                $('.card-header').removeClass('bg-primary')
                $('.card-header').addClass('bg-danger')
                $('.card-header').append('<h3 class="text-center text-white">Belum waktu untuk melakukan absensi</h3>')
                toastr["warning"]('Batas absen masuk melebihi waktu yang ditentukan')
            } else if (formattedTime <= "{{$jamMasuk_akhir}}" || formattedTime >= "{{$jamMasuk_awal}}") {
                $('.card-header').empty()
                $('.card-header').addClass('bg-primary')
                $('.card-header').removeClass('bg-danger')
                $('.card-header').append('<h3 class="text-center text-white">Belum waktu untuk melakukan absensi</h3>')
                // ABSENSI
                let config = {
                    fps: 10,
                    qrbox: {
                        width: 600,
                        height: 600
                    },
                    rememberLastUsedCamera: true,
                    // Only support camera scan type.
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                };

                let html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", config, /* verbose= */ false);
                html5QrcodeScanner.render(onScanSuccess);
            }



            // setInterval(() => {
            //     configDB()
            // }, 5000);
        });
    </script>
</body>

</html>
