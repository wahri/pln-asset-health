<!DOCTYPE html>
<html lang="en" class="color-sidebar sidebarcolor1">

@include('layouts.head')

<body >
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('components.sidebar')
        <!--end sidebar wrapper -->
        <!--start header -->
        @include('components.header')
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
          @yield('content')
        </div>
        <!--end page wrapper -->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class="bx bxs-up-arrow-alt"></i></a>
        <!--End Back To Top Button-->
       @include('components.footer')
    </div>
    <!--end wrapper-->
  @include('layouts.script')
</body>

</html>