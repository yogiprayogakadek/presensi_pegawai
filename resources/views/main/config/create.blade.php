@extends('template.master')

@section('page-title', 'Pegawai')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            Tambah Pegawai
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
                <form action="{{route('pegawai.store')}}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" placeholder="masukkan nip" value="{{old('nip')}}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama" value="{{old('nama')}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tempat lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="masukkan tempat lahir" value="{{old('tempat_lahir')}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="masukkan tanggal lahir" value="{{old('tanggal_lahir')}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                @foreach ($jenisKelamin as $jk)
                                    <option value="{{$jk}}">{{$jk == '' ? 'Pilih jenis kelamin' : $jk}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Status perkawinan</label>
                            <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                @foreach ($statusPerkawinan as $sp)
                                    <option value="{{$sp}}">{{$sp == '' ? 'Pilih status perkawinan' : $sp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pendidikan terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                                @foreach ($pendidikanTerakhir as $pt)
                                    <option value="{{$pt}}">{{$pt == '' ? 'Pilih pendidikan terakhir' : $pt}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" placeholder="masukkan alamat" autocomplete="off" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" name="telp" id="telp" placeholder="masukkan nomor telp" value="{{old('telp')}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="masukkan alamat email" value="{{old('email')}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password" value="12345678" readonly autocomplete="off">
                            <p class="text-small text-muted font-italic">Password default <span class="font-weight-bold">12345678</span> </p>
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto" placeholder="masukkan foto" autocomplete="off">
                            <p class="text-small text-muted font-italic">Biarkan kosong jika belum ada foto</p>
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
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\PegawaiRequest', '#form') !!}

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
