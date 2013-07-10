<div class="container">
    <div class="brand-wrap pull-left">
        <div class="brand-img">
            <a class="brand" href="#">
                <img src="{{ URL::base() }}/mhsdosen/assets/images/logo.png" alt="" style="width: 338px; height: 33px; margin-right: 20px;">
            </a>
        </div>
    </div>

    <div id="header-right" class="clearfix">
        <div id="nav-toggle" data-toggle="collapse" data-target="#navigation" class="collapsed">
            <i class="icon-caret-down"></i>
        </div>
        <div id="dropdown-lists">
            <div class="item-wrap">
                @if(Auth::user()->role == 3)
                <a class="item" href="http://infokhs.umm.ac.id/" target="_blank" title="Go To KHS Main Web">
                    <span class="item-icon"><i class="icon-exclamation-sign"></i></span>
                    <span class="item-label">Go To KHS Main Web</span>
                </a>
                @endif
            </div>
            <div class="item-wrap">
                <a class="item" href="http://umm.ac.id" target="_blank" title="Go To UMM Main Web">
                    <span class="item-icon"><i class="icon-exclamation-sign"></i></span>
                    <span class="item-label">Go To UMM Main Web</span>
                </a>
            </div>
        </div>

        <div id="header-functions" class="pull-right">
            <div id="user-info" class="clearfix">
                <span class="info">
                    Selamat Datang
                    <span class="name">{{ $user->namadepan }} {{ $user->namabelakang }}</span>
                </span>
                <div class="avatar">
                    <a class="dropdown-toggle" title="open" href="#" data-toggle="dropdown">
                        @if(empty($profil->foto))
                        {{ HTML::image(URL::base().'/sample/default.jpeg', 'Default User Image'); }}
                        @else
                        {{ HTML::image(URL::base().'/uploads/thumbnails/'.$profil->foto, 'User Image'); }}
                        @endif
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to_route('profil') }}"><i class="icol-user"></i> Pengaturan Profil</a></li>    
                        <li class="divider"></li>
                        @if(Auth::user()->role == 3)
                        <li><a href="{{ URL::to_route('mahasiswalogout') }}"><i class="icol-key"></i> Logout</a></li>
                        @elseif(Auth::user()->role == 2)
                        <li><a href="{{ URL::to_route('dosenlogout') }}"><i class="icol-key"></i> Logout</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div id="logout-ribbon">
                @if(Auth::user()->role == 3)
                <a href="{{ URL::to_route('mahasiswalogout') }}"><i class="icon-off"></i></a>
                @elseif(Auth::user()->role == 2)
                <a href="{{ URL::to_route('dosenlogout') }}"><i class="icon-off"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>