@extends('template.master')

@section('page-title', 'Config')
@section('page-sub-title', 'Data')


@section('content')
    <div class="row">
        <div class="col-4 div-preview-profil mx-auto">
            <div class="card card-profile-1 mb-4">
                <div class="card-body text-center">
                    <div class="avatar box-shadow-2 mb-3">
                        <img src="{{ asset(auth()->user()->foto) }}" alt="">
                    </div>
                    <h5 class="m-0">{{ username(auth()->user()->role) }}</h5>
                    <p class="mt-0">{{ ucfirst(auth()->user()->role) }}</p>
                    <div class="row text-left">
                        <div class="col-3">
                            NIP
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $pegawai->nip }}</div>

                        <div class="col-3">
                            Nama
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $pegawai->nama }}</div>

                        <div class="col-3">
                            Tempat/Tanggal Lahir
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $pegawai->tempat_lahir }}/{{ $pegawai->tanggal_lahir }}</div>

                        <div class="col-3">
                            Jenis Kelamin
                        </div>
                        <div class="col-1">:</div>
                        <div class="col-8">{{ $pegawai->jenis_kelamin }}</div>
                    </div>

                    <button class="btn btn-primary btn-rounded mt-3 mr-2 btn-password">Update Password</button>
                    <button class="btn btn-success btn-rounded mt-3 btn-profil">Update Profil</button>
                </div>
            </div>
        </div>

        <div class="col-8 div-profil" hidden>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Update Profil</h4>
                    </div>
                </div>
                <form action="{{ route('staff.profil.update') }}" method="POST" id="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="user_id" id="user_id" value="{{ $pegawai->user_id }}"
                            class="form-control">
                        <input type="hidden" name="id" id="id" value="{{ $pegawai->id }}"
                            class="form-control">
                        <div class="form-group">
                            <label for="">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip"
                                placeholder="masukkan nip" value="{{ $pegawai->nip }}" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="masukkan nama" value="{{ $pegawai->nama }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tempat lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                                placeholder="masukkan tempat lahir" value="{{ $pegawai->tempat_lahir }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                                placeholder="masukkan tanggal lahir" value="{{ $pegawai->tanggal_lahir }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                @foreach ($jenisKelamin as $jk)
                                    <option value="{{ $jk }}"
                                        {{ $jk == $pegawai->jenis_kelamin ? 'selected' : '' }}>
                                        {{ $jk == '' ? 'Pilih jenis kelamin' : $jk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Status perkawinan</label>
                            <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                @foreach ($statusPerkawinan as $sp)
                                    <option value="{{ $sp }}"
                                        {{ $sp == $pegawai->status_perkawinan ? 'selected' : '' }}>
                                        {{ $sp == '' ? 'Pilih status perkawinan' : $sp }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pendidikan terakhir</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                                @foreach ($pendidikanTerakhir as $pt)
                                    <option value="{{ $pt }}"
                                        {{ $pt == $pegawai->pendidikan_terakhir ? 'selected' : '' }}>
                                        {{ $pt == '' ? 'Pilih pendidikan terakhir' : $pt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" placeholder="masukkan alamat" autocomplete="off"
                                rows="5">{{ $pegawai->alamat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" name="telp" id="telp"
                                placeholder="masukkan nomor telp" value="{{ $pegawai->telp }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto" id="foto"
                                placeholder="masukkan foto" autocomplete="off">
                            <p class="text-small text-muted font-italic">Biarkan kosong jika belum ada foto</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="btn btn-danger btn-cancel-profil" type="button">Batal</button>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-8 div-password" hidden>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>Update Password</h4>
                    </div>
                </div>
                <form action="{{ route('staff.profil.update.password') }}" method="POST" id="form2">
                    @csrf
                    <div class="card-body">
                        {{-- <input type="hidden" name="update_password" id="update_password" value="update-password"
                            class="form-control"> --}}

                        <div class="form-group">
                            <label for="">Password Sekarang</label>
                            <input type="password" class="form-control" name="current_password" id="current_password"
                                placeholder="masukkan password sekarang" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" id="new_password"
                                placeholder="masukkan password baru" autocomplete="off" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Password Konfirmasi</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                placeholder="masukkan password konfirmasi" autocomplete="off" autofocus>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="btn btn-danger btn-cancel-password" type="button">Batal</button>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/print/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\UpdateProfilRequest', '#form') !!}
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePasswordRequest', '#form2') !!}
    <script>
        $(document).ready(function() {
            @if (session('status'))
                Swal.fire(
                    "{{ session('title') }}",
                    "{{ session('message') }}",
                    "{{ session('status') }}",
                );
            @endif

            $('body').on('click', '.btn-profil', function() {
                $('.div-profil-preview').removeClass('mx-auto');
                $('.div-profil').prop('hidden', false)
                $('.div-password').prop('hidden', true)
            });

            $('body').on('click', '.btn-cancel-profil', function() {
                $('.div-profil-preview').addClass('mx-auto');
                $('.div-profil').prop('hidden', true)
                $('.div-password').prop('hidden', true)
            });

            $('body').on('click', '.btn-password', function() {
                $('.div-profil-preview').removeClass('mx-auto');
                $('.div-profil').prop('hidden', true)
                $('.div-password').prop('hidden', false)
            });

            $('body').on('click', '.btn-cancel-password', function() {
                $('.div-profil-preview').addClass('mx-auto');
                $('.div-profil').prop('hidden', true)
                $('.div-password').prop('hidden', true)
            });
        });
    </script>
@endpush
