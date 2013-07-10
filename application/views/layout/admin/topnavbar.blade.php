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
                <a class="item" href="http://umm.ac.id" target="_blank">
                    <span class="item-icon"><i class="icon-exclamation-sign"></i></span>
                    <span class="item-label">Go To UMM Main Web</span>
                </a>
            </div>
            <div class="item-wrap">
                <a class="item" href="http://informatika.umm.ac.id/" target="_blank">
                    <span class="item-icon"><i class="icon-envelope"></i></span>
                    <span class="item-label">Go To IT Main Web</span>
                </a>
            </div>
        </div>

        <div id="header-functions" class="pull-right">
            <div id="user-info" class="clearfix">
                <span class="info">
                    Selamat Datang,
                    <span class="name">{{ $user->namadepan }} {{ $user->namabelakang }}</span>
                </span>
                <div class="avatar">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        {{ HTML::image(URL::base().'/sample/default.jpeg', 'Coba'); }}
                    </a>
                </div>
            </div>
            <div id="logout-ribbon">
                <a href="{{ URL::to_route('adminlogout') }}"><i class="icon-off"></i></a>
            </div>
        </div>
    </div>
</div>