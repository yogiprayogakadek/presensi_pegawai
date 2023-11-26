@extends('template.master')

@section('page-title', 'Dashboard')
@section('page-sub-title', 'Data')

@section('content')
<div class="row py-4 pt-5">
    <div class="col-6 ml-5" id="qrCode"></div>
</div>
@endsection

@push('script')
{{-- <script src="https://unpkg.com/html5-qrcode"></script> --}}
<script src="{{asset('assets/js/html5-qrcode.min.js')}}"></script>
<script>
    function qrcode() {
        $.get("/staff/qrcode", function(data) {
            $('#qrCode').append(data);
        });
    }

    qrcode()
    setInterval(() => {
        $('#qrCode').empty();
        qrcode()
    }, 30000);

</script>
@endpush
