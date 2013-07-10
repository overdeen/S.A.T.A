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
                        @endif<a href="{{ URL::to_route('admin') }}"><i class="icol-application-home"></i> Dashboard Utama </a></li>
                </ul>
            </li>           
            @if($menu == 'Penjadwalan')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Manage Jadwal"><i class="icon-calendar-month"></i><span class="nav-title">JADWAL</span>
                </span>
                <ul class="inner-nav">
                    @if($menu2 == 'Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalansempro') }}"><i class="icol-calendar-2"></i> Jadwal Sempro</a></li>
                    @if($menu2 == 'Seminar Hasil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalansemhas') }}"><i class="icol-calendar-2"></i> Jadwal Semhas</a></li>
                    @if($menu2 == 'Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalanujian') }}"><i class="icol-calendar-2"></i> Jadwal Ujian TA</a></li>
                    <li>
                        <a></a>
                    </li>
                    @if($menu2 == 'Penguji Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalanpengujisempro') }}"><i class="icol-calendar-2"></i> Jadwal Penguji Sempro</a></li>
                    @if($menu2 == 'Penguji Seminar Hasil')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalanpengujisemhas') }}"><i class="icol-calendar-2"></i> Jadwal Penguji Semhas</a></li>
                    @if($menu2 == 'Penguji Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('penjadwalanpengujiujian') }}"><i class="icol-calendar-2"></i> Jadwal Penguji Ujian TA</a></li>
                </ul>
            </li>
            @if($menu == 'Pembimbing')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Manage Pembimbing Tugas Akhir"><i class="icon-archive"></i><span class="nav-title">PEMBIMBING</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage Pembimbing')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('managepembimbing') }}"><i class="icol-paste-plain"></i> Manage Pembimbing</a></li>
                </ul>
            </li>
            @if($menu == 'Hasil')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Update Hasil"><i class="icon-archive"></i><span class="nav-title">HASIL</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Update Hasil Seminar Proposal')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('updatehasilsempro') }}"><i class="icol-paste-plain"></i> Update Hasil Sempro</a></li>
                    @if($menu2 == 'Update Hasil Ujian TA')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('updatehasilujian') }}"><i class="icol-paste-plain"></i> Update Hasil Ujian TA</a></li>
                </ul>
            </li>
            @if($menu == 'User')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Manage User"><i class="icon-users"></i><span class="nav-title">USER</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage User')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('viewuser') }}"><i class="icol-page-paste"></i> Manage User Terdaftar</a></li>
                    @if($menu2 == 'Data Mahasiswa IT')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('viewdatamahasiswa') }}"><i class="icol-page-paste"></i> Data Mahasiswa IT</a></li>
                </ul>
            </li>           
            @if($menu == 'Informasi')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Manage Informasi"><i class="icon-info-sign"></i><span class="nav-title">INFORMASI</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage Informasi')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('informasi') }}"><i class="icol-hammer-screwdriver"></i> Manage Informasi</a></li>
                </ul>
            </li>
            @if($menu == 'Berkas Persyaratan')
            <li class="active">
                @else
            <li>
                @endif
                <span title="Manage Berkas Persyaratan"><i class="icon-file-zip"></i><span class="nav-title">BERKAS</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'Manage Berkas Persyaratan')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('berkas') }}"><i class="icol-hammer-screwdriver"></i> Manage Berkas</a></li>
                </ul>
            </li>
            @if($menu == 'Manager')
            <li class="active">
                @else
            <li>
                @endif
                <span title="File Manager"><i class="icon-list-2"></i><span class="nav-title">MANAGER</span></span>
                <ul class="inner-nav">
                    @if($menu2 == 'File Manager')
                    <li class="active">
                        @else
                    <li>
                        @endif<a href="{{ URL::to_route('filemanager') }}"><i class="icol-hammer-screwdriver"></i> File Manager</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>