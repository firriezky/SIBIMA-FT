<header class="navbar">
    <div class="container-fluid">

        <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">
            <span class="fa fa-bars"></span>
        </button>
        <a class="navbar-brand" href="#"></a>

        {{-- Left Menu Navabar--}}
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="#">
                    <span class="fa fa-bars"></span>
                </a>
            </li>

        </ul>

        {{-- Right Menu Navbar--}}
        <ul class="nav navbar-nav pull-right navbar-right nav-profile">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ url('img/logo/logo_only_small.png') }}" class="img-avatar">
                    <span class="hidden-md-down">{{ auth()->guard('admin')->user()->username }} <strong>(ADMIN)</strong></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-xs-center">
                        <strong>Settings</strong>
                    </div>

                    <a class="dropdown-item" href="{{ url('admin/password') }}"><i class="fa fa-key"></i> Change Password</a>
                    <div class="divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</header>
