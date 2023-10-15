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
                            Edit Pegawai
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
                <form action="{{route('pegawai.update')}}" method="POST" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="user_id" id="user_id" value="{{$pegawai->user_id}}" class="form-control">
                        <input type="hidden" name="id" id="id" value="{{$pegawai->id}}" class="form-control">
                        <div class="form-group">
                            <label for="">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" placeholder="masukkan nip" value="{{$pegawai->nip}}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama" value="{{$pegawai->nama}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tempat lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="masukkan tempat lahir" value="{{$pegawai->tempat_lahir}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="masukkan tanggal lahir" value="{{$pegawai->tanggal_lahir}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                @foreach ($jenisKelamin as $jk)
                                    <option value="{{$jk}}" {{$jk == $pegawai->jenis_kelamin ? 'selected' : ''}}>{{$jk == '' ? 'Pilih jenis kelamin' : $jk}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Status perkawinan</label>
                            <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                @foreach ($statusPerkawinan as $sp)
                                    <option value="{{$sp}}" {{$sp == $pegawai->status_perkawinan ? 'selected' : ''}}>{{$sp == '' ? 'Pilih status perkawinan' : $sp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pendidikan terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                                @foreach ($pendidikanTerakhir as $pt)
                                    <option value="{{$pt}}" {{$pt == $pegawai->pendidikan_terakhir ? 'selected' : ''}}>{{$pt == '' ? 'Pilih pendidikan terakhir' : $pt}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" placeholder="masukkan alamat" autocomplete="off" rows="5">{{$pegawai->alamat}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" name="telp" id="telp" placeholder="masukkan nomor telp" value="{{$pegawai->telp}}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto" placeholder="masukkan foto"  autocomplete="off">
                            <p class="text-small text-muted font-italic">Biarkan kosong jika belum ada foto</p>
                        </div>
                        <div class="form-group">
                            <label for="">Status Pegawai</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{$pegawai->is_active == true ? 'selected' : ''}}>Aktif</option>
                                <option value="0" {{$pegawai->is_active == false ? 'selected' : ''}}>Tidak aktif</option>
                            </select>
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
