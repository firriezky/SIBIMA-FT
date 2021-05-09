<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <i class="fa fa-tachometer"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/agenda') }}">
                    <i class="fa fa-file-o"></i> Agenda
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dsc') }}">
                    <i class="fa fa-file-o"></i> Monitoring Mentor
                </a>
            </li>

            <li class="nav-item nav-dropdown {{ Request::is('admin/berita-mentoring*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-files-o"></i> Berita Mentoring</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/berita-mentoring') }}">
                            <div class="nav-padding">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Manage
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/berita-mentoring/export') }}">
                            <div class="nav-padding">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i> Export
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/berita-mentoring/unreported') }}">
                            <div class="nav-padding">
                                <i class="fa fa-warning" aria-hidden="true"></i> Unreported
                            </div>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item nav-dropdown {{ Request::is('admin/kelompok*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-group" aria-hidden="true"></i> Kelompok</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/') }}">
                            <div class="nav-padding">
                                <i class="fa fa-eye" aria-hidden="true"></i> Manage
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/create-ikhwan') }}">
                            <div class="nav-padding">
                                <i class="fa fa-male" aria-hidden="true"></i>  Buat Ikhwan
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/create-akhwat') }}">
                            <div class="nav-padding">
                                <i class="fa fa-female" aria-hidden="true"></i>  Buat Akhwat
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/validasi') }}">
                            <div class="nav-padding">
                                <i class="fa fa-step-backward" aria-hidden="true"></i> Validasi
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/export') }}">
                            <div class="nav-padding">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i> Export
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kelompok/generate') }}">
                            <div class="nav-padding">
                                <i class="fa fa-random" aria-hidden="true"></i> Generate
                            </div>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item nav-dropdown {{ Request::is('admin/kalender*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-calendar"></i> Kalender ICB</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/kalender') }}">
                            <div class="nav-padding">
                                <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Lihat Kalender
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ url('admin/kalender/event') }}>
                            <div class="nav-padding">
                                <i class="fa fa-times-circle-o" aria-hidden="true"></i> Manage Event
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown {{ Request::is('admin/presensi*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-check-square-o"></i> Presensi</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/presensi/general') }}">
                            <div class="nav-padding">
                                <i class="fa fa-inbox" aria-hidden="true"></i> General
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/presensi/perizinan') }}">
                            <div class="nav-padding">
                                <i class="fa fa-handshake-o" aria-hidden="true"></i> Perizinan
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ url('admin/presensi/talaqi') }}>
                            <div class="nav-padding">
                                <i class="fa fa-address-book" aria-hidden="true"></i> Talaqi
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ url('admin/presensi/talaqi/export') }}>
                            <div class="nav-padding">
                                <i class="fa fa-download" aria-hidden="true"></i> Export Talaqi
                            </div>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item nav-dropdown {{ Request::is('admin/data*') ? 'open': null }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-database" aria-hidden="true"></i> Data</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/data/mentor') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Mentor
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/data/mentee') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user" aria-hidden="true"></i> Mentee
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/data/admin') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user-secret" aria-hidden="true"></i> Admin
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('admin/data/upload') }}">
                            <div class="nav-padding">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>  Upload
                            </div>
                        </a>
                    </li>
                    <li class="nav-dropdown-items">
                        <a class="nav-link" href="{{ url('admin/data/manage-db') }}">
                            <div class="nav-padding">
                                <i class="fa fa-user-secret" aria-hidden="true"></i>  Manage DB
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/pengumuman') }}"><i class="fa fa-bullhorn"></i> Pengumuman</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/tugas-besar') }}"><i class="fa fa-briefcase"></i> Tugas Besar</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/materi') }}"><i class="fa fa-book"></i> Materi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/questioner') }}"><i class="fa fa-question-circle-o"></i> Kuesioner</a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link" href="https://www.facebook.com/groups/sibima" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i> Helpdesk</a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/about-bima') }}">
                    <i class="fa fa-code"></i> About SIBIMA
                </a>
            </li>
        </ul>
    </nav>
</div>
