@extends('template.master')

@section('page-title', 'Dashboard')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div id="reader" width="600px"></div>
                </div>
                <div class="card-footer text-center bg-success" hidden></div>
            </div>
        </div>

        {{-- <div class="col-6 mx-auto text-center" id="test"></div> --}}
    </div>
@endsection

@push('script')
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            $.get("/staff/absensi/store/" + decodedText, function (data) {
                if(data.status == 200) {
                    $('.card-footer').empty();
                    $('.card-footer').append('<h4 class="text-white">Hai, selamat pagi Yogi! Absensimu berhasil disimpan </h4>')
                    $('.card-footer').prop('hidden', false)
                } else {
                    $('.card-footer').empty();
                    $('.card-footer').prop('hidden', true)
                }
            });
        }

        let config = {
            fps: 10,
            qrbox: {
                width: 1000,
                height: 1000
            },
            rememberLastUsedCamera: true,
            // Only support camera scan type.
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        };

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess);
    </script>

    {{-- <script>
        function qrcode(){
            $.get("/dashboard/qrcode",function (data) {
                $('#test').append(data);
            });
        }

        qrcode()
        setInterval(() => {
            $('#test').empty();
            qrcode()
        }, 30000);
    </script> --}}
@endpush
