<!DOCTYPE html>
<html lang="es">
    <head>
        @include('includes.head')
    </head>
    <body>
        <div id="all">
        <!-- Header - Navbar Start -->
        @include('includes.header')
        <!-- Header - Navbar End -->

        <!-- Content Start -->
        @yield('content')
        <!-- Content End -->

        <!-- Footer Start -->
        @include('includes.footer')
        <!-- Footer End -->
        </div>
    </body>
</html>
