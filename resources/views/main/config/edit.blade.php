@extends('template.master')

@section('page-title', 'Config')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Edit Config
                        </div>
                        {{-- @can('petugas') --}}
                            <div class="col-6 d-flex align-items-center">
                                <div class="m-auto"></div>
                                <a href="{{route('pegawai.index')}}">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="nav-icon fa fa-eye font-weight-bold"></i> Lihat Data
                                    </button>
                                </a>
                            </div>
                        {{-- @endcan --}}
                    </div>
                </div>
                <form action="{{route('config.update')}}" method="POST" id="form">
                    @csrf
                    <div class="card-body">
                        @php
                            $data = json_decode($config->json_data, true);
                        @endphp
                        <input type="hidden" name="id" id="id" value="{{$config->id}}" class="form-control">
                        <div class="form-group">
                            <label for="">Jam Masuk</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="time" class="form-control" name="jam_masuk_batas_awal" id="jam_masuk_batas_awal" placeholder="masukkan batas awal" value="{{$data['jam_masuk']['batas_awal']}}" autocomplete="off" autofocus>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control" name="jam_masuk_batas_akhir" id="jam_masuk_batas_akhir" placeholder="masukkan batas akhir" value="{{$data['jam_masuk']['batas_akhir']}}" autocomplete="off" autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Keluar</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="time" class="form-control" name="jam_keluar_batas_awal" id="jam_keluar_batas_awal" placeholder="masukkan batas awal" value="{{$data['jam_keluar']['batas_awal']}}" autocomplete="off" autofocus>
                                </div>
                                <div class="col-3">
                                    <input type="time" class="form-control" name="jam_keluar_batas_akhir" id="jam_keluar_batas_akhir" placeholder="masukkan batas akhir" value="{{$data['jam_keluar']['batas_akhir']}}" autocomplete="off" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')

<script>
    $(document).ready(function () {
        @if(session('status'))
        Swal.fire(
            "{{session('title')}}",
            "{{session('message')}}",
            "{{session('status')}}",
        );
        @endif
    });
</script>
@endpush
