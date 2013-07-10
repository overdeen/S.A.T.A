@if(Auth::user()->role == 3)
<aside id="sidebar">
    <nav id="navigation" class="collapse">
        <ul>
            @if($menu == 'Dashboard')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Home"><i class="icon-home"></i><span class="nav-title">HOME</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Home Dashboard')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::base() }}/mahasiswa"><i class="icol-application-home"></i> Dashboard Utama</a></li>
                </ul>
            </li>
            @if($menu == 'Profil')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Profil"><i class="icon-user"></i><span class="nav-title">PROFIL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage Profil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('profil') }}"><i class="icol-hammer-screwdriver"></i> Pengaturan Profil</a></li>
                </ul>
            </li>
            @if($menu == 'Proposal')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Proposal"><i class="icon-book"></i><span class="nav-title">PROPOSAL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Judul Terdaftar')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('TAterdaftar') }}"><i class="icol-application-add"></i> Judul TA Terdaftar</a></li>
                    @if($menu2 == 'Manage Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('proposalmahasiswa') }}"><i class="icol-application-cascade"></i> Pengaturan Proposal</a></li>
                    @if($menu2 == 'Dosen Pembimbing')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('dosenpembimbing') }}"><i class="icol-user-business"></i> Dosen Pembimbing</a></li>
                </ul>
            </li>
            @if($menu == 'Daftar')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Daftar"><i class="icon-list-2"></i><span class="nav-title">DAFTAR</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Daftar Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('daftarsempro') }}"><i class="icol-page-paste"></i> Daftar Seminar Proposal</a></li>
                    @if($menu2 == 'Daftar Seminar Hasil & Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('daftarsemhasujian') }}"><i class="icol-page-paste"></i> Daftar Semhas & Ujian TA</a></li>
                </ul>
            </li>
            @if($menu == 'Bimbingan')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Bimbingan"><i class="icon-users"></i><span class="nav-title">BIMBINGAN</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Asistensi Bimbingan')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('bimbingan') }}"><i class="icol-hammer-screwdriver"></i> SK & Asistensi Bimbingan</a></li>
                </ul>
            </li>
            @if($menu == 'Jadwal')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Jadwal"><i class="icon-calendar-month"></i><span class="nav-title">JADWAL</span>
                </span>
                <ul class="inner-nav">
                    @if($menu2 == 'Jadwal Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalsempro') }}"><i class="icol-calendar-2"></i> Jadwal Seminar Proposal</a></li>
                    @if($menu2 == 'Jadwal Seminar Hasil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalsemhas') }}"><i class="icol-calendar-2"></i> Jadwal Seminar Hasil</a></li>
                    @if($menu2 == 'Jadwal Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalujian') }}"><i class="icol-calendar-2"></i> Jadwal Ujian TA</a></li>
                </ul>
            </li>
            @if($menu == 'Hasil')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Hasil"><i class="icon-archive"></i><span class="nav-title">HASIL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Hasil Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('hasilsempro') }}"><i class="icol-paste-plain"></i> Hasil Seminar Proposal</a></li>
                    @if($menu2 == 'Hasil Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('hasilujian') }}"><i class="icol-paste-plain"></i> Hasil Ujian TA</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
@elseif(Auth::user()->role == 2)
<aside id="sidebar">
    <nav id="navigation" class="collapse">
        <ul>
            @if($menu == 'Dashboard')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Home"><i class="icon-home"></i><span class="nav-title">HOME</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Home Dashboard')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::base() }}/dosen"><i class="icol-application-home"></i> Dashboard Utama</a></li>
                </ul>
            </li>
            @if($menu == 'Profil')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Profil"><i class="icon-user"></i><span class="nav-title">PROFIL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage Profil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('profil') }}"><i class="icol-hammer-screwdriver"></i> Pengaturan Profil</a></li>
                </ul>
            </li>
            @if($menu == 'Approval')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Approval"><i class="icon-file"></i><span class="nav-title">PROPOSAL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Approval Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif
                        <a href="{{ URL::to_route('approval') }}"><i class="icol-hammer-screwdriver"></i> Approval Proposal </a>
                    </li>
                </ul>
            </li>
            @if($menu == 'Bimbingan')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Bimbingan"><i class="icon-user"></i><span class="nav-title">BIMBINGAN</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Asistensi Bimbingan')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('asistensibimbingan') }}"><i class="icol-hammer-screwdriver"></i> Asistensi Bimbingan TA</a></li>
                </ul>
            </li>
            @if($menu == 'Jadwal Penguji')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Jadwal Penguji"><i class="icon-calendar-month"></i><span class="nav-title">JADWAL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Jadwal Penguji Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalpengujisempro') }}"><i class="icol-application-add"></i> Jadwal Penguji Sempro</a></li>
                    @if($menu2 == 'Jadwal Penguji Seminar Hasil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalpengujisemhas') }}"><i class="icol-application-cascade"></i> Jadwal Penguji Semhas</a></li>
                    @if($menu2 == 'Jadwal Penguji Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('jadwalpengujiujian') }}"><i class="icol-user-business"></i> Jadwal Penguji Ujian TA</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
@endif