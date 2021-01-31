{{-- Navbar Mentee --}}
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

                    @if(strtolower(Auth::guard('mentee')->user()->jk) == 1)
                        <img src="{{ url('img/avatar/avatar-sibima01.png') }}" class="img-avatar">
                    @else
                        <img src="{{ url('img/avatar/avatar-sibimi01.png') }}" class="img-avatar">
                    @endif

                    <span class="hidden-md-down">{{ Auth::guard('mentee')->user()->nama }} <strong>(MENTEE)</strong></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <div class="dropdown-header text-xs-center">
                        <strong>Settings</strong>
                    </div>

                    <a class="dropdown-item" href="{{ url('mentee/profile') }}"><i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="{{ url('mentee/password') }}"><i class="fa fa-key"></i> Change Password</a>

                    <div class="divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-lock"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</header>
