@extends('template.master')

@section('page-title', 'Dashboard')
@section('page-sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-5 mx-auto">
            <div class="card card-profile-1 mb-4">
                <div class="card-body text-center">
                    <div class="avatar box-shadow-2 mb-3">
                        <img src="{{asset(auth()->user()->foto)}}" alt="">
                    </div>
                    <h5 class="m-0">{{username(auth()->user()->role)}}</h5>
                    <p class="mt-0">{{ucfirst(auth()->user()->role)}}</p>
                    <p class="font-italic font-weight-bold">Selamat datang di Dashboard Resmi KPU! Kami senang Anda berada di sini.
                        Mari bersama-sama menciptakan proses pemilihan yang transparan dan adil
                        untuk masa depan yang lebih baik.</p>
                    {{-- <a href="{{auth()->user()->role == 'customer' ? route('customer.package.index') : route('package.index')}}">
                        <button class="btn btn-primary btn-rounded">Find best tourist</button> --}}
                    </a>
                    <div class="card-socials-simple mt-4">
                        Komisi Pemilihan Umum Kabupaten Ngada
                        {{-- <a href="">
                            <i class="i-Linkedin-2"></i>
                        </a>
                        <a href="">
                            <i class="i-Facebook-2"></i>
                        </a>
                        <a href="">
                            <i class="i-Twitter"></i>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
