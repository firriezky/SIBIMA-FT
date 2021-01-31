<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.2
 * @link http://coreui.io
 * Copyright (c) 2016 creativeLabs Łukasz Holeczek
 * @license MIT
 -->

<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.component.head')
    {!! Analytics::render() !!}
</head>


<body class="navbar-fixed sidebar-nav fixed-nav footer-fixed">

    @include('layout.component.mentee.navbar_mentee')

    @include('layout.component.mentee.sidebar_mentee')

    <!-- Main content -->
    <main class="main">
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.conainer-fluid -->
    </main>

    @include('layout.component.footer')

    @include('layout.component.js_body')

</body>


</html>