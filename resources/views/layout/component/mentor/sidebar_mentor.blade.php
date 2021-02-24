{{-- Sidebar Mentor --}}
<div class="sidebar">

    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentor/dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentor/pengumuman*') ? 'active': null }}"
                   href="{{ url('mentor/pengumuman') }}"><i class="fa fa-bullhorn"></i> Pengumuman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentor/berita-mentoring*') ? 'active': null }}"
                   href="{{ url('mentor/berita-mentoring') }}"><i class="fa fa-bar-chart"></i> Berita Mentoring</a>
            </li>
            <li class="nav-item nav-dropdown {{ Request::is('mentor/kelompok*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-users"></i> Kelompok</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('mentor/kelompok') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Mentor
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('mentor/kelompok/asisten') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user" aria-hidden="true"></i> Asisten
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-book"></i> Perpustakaan</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="nav-padding">
                                <i class="fa fa-search" aria-hidden="true"></i> Koleksi
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="nav-padding">
                                <i class="fa fa-history" aria-hidden="true"></i> Peminjaman
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentor/materi*') ? 'active': null }}"
                   href="{{ url('mentor/materi') }}"><i class="fa fa-cloud-download"></i> Download</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentor/kehadiran') }}"><i class="fa fa-check-circle-o"></i> Kehadiran Talaqi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentor/questioner*') ? 'active': null }}"
                   href="{{ url('mentor/questioner') }}"><i class="fa fa-question-circle-o"></i> Kuesioner</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/groups/sibima" target="_blank">
                    <i class="fa fa-envelope" aria-hidden="true"></i> Helpdesk
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentor/about-bima') }}">
                    <i class="fa fa-code"></i> About SIBIMA
                </a>
            </li>

        </ul>
    </nav>
</div>
