<div class="main-header">
    <div class="logo">
        <a href="/">
            <img src="{{asset('assets/images/logo.png')}}" alt="" />
        </a>
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    @stack('search')

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                Welcome, <strong>{{username(auth()->user()->role)}}</strong>!
                <img src="{{asset(auth()->user()->foto)}}" id="userDropdown" alt="" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" />

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{auth()->user()->role}}
                    </div>
                    @can('pegawai')
                    <a class="dropdown-item" href="{{route('staff.profil.index')}}">Profil</a>
                    @endcan
                    {{-- <a class="dropdown-item">Billing history</a> --}}
                    <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{route('logout')}}">Sign
                        out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
