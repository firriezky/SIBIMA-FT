{{-- Sidebar Mentee --}}
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentee/dashboard*') ? 'active': null }}"
                   href="{{ url('mentee/dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/absen') }}"><i class="fa fa-bar-chart"></i> Absensi QR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/nilai') }}"><i class="fa fa-bar-chart"></i> Nilai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/kelompok') }}"><i class="fa fa-users"></i> Kelompok</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/perizinan') }}"><i class="fa fa-check-circle-o"></i> Perizinan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentee/materi*') ? 'active': null }}"
                   href="{{ url('mentee/materi') }}"><i class="fa fa-book"></i> Materi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/tugas-besar') }}"><i class="fa fa-briefcase"></i> Tugas Besar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('mentee/questioner*') ? 'active': null }}"
                   href="{{ url('mentee/questioner') }}"><i class="fa fa-question-circle-o"></i> Kuesioner</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/groups/sibima" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i> Helpdesk</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('mentee/about-bima') }}">
                    <i class="fa fa-code"></i> About SIBIMA
                </a>
            </li>
        </ul>
    </nav>
</div>
