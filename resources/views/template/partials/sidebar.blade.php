<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <div class="navigation-left">
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('dashboard.index') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashoard</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Str::contains(request()->url(), 'pegawai') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('pegawai.index') }}">
                    <i class="nav-icon i-Administrator"></i>
                    <span class="nav-text">Pegawai</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ Request::is('absensi/all') ? 'active' : (Request::is('retensi/by-name') ? 'active' : '') }}" data-item="absensi">
                <a class="nav-item-hold" href="javascript:void(0)">
                    <i class="nav-icon i-Hospital"></i>
                    <span class="nav-text">Absensi</span>
                </a>
                <div class="triangle"></div>
            </li>
            {{-- <li class="nav-item {{ Str::contains(request()->url(), 'medicine') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('medicine.index') }}">
                    <i class="nav-icon i-Medicine-2"></i>
                    <span class="nav-text">Medicine</span>
                </a>
                <div class="triangle"></div>
            </li> --}}
            {{-- <li class="nav-item {{ Str::contains(request()->url(), 'batch') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('batch.index') }}">
                    <i class="nav-icon i-Bar-Chart-3"></i>
                    <span class="nav-text">Batch</span>
                </a>
                <div class="triangle"></div>
            </li> --}}
            {{-- <li class="nav-item {{ Str::contains(request()->url(), 'outgoing') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{route('outgoing.index')}}">
                    <i class="nav-icon i-Medicine-3"></i>
                    <span class="nav-text">Outgoing</span>
                </a>
                <div class="triangle"></div>
            </li> --}}
        </div>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none ps" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="absensi" style="display: block;">
            <li class="nav-item">
                <a class="{{ Request::is('absensi/all') ? 'open' : ''}}" href="{{route('absensi.all')}}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">Rekap Semua</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::is('absensi/by-name') ? 'open' : ''}}" href="{{route('absensi.by-name')}}">
                    <i class="nav-icon i-Clock-4"></i>
                    <span class="item-name">Rekap by Nama</span>
                </a>
            </li>
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>

    <div class="sidebar-overlay"></div>
</div>
