<!DOCTYPE html>
<html lang="zxx">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>News</title>
    <!-- plugin css for this page -->
    <link
      rel="stylesheet"
      href=" {{asset('frontend/vendors/mdi/css/materialdesignicons.min.css') }}"
    />
    <link rel="stylesheet" href=" {{ asset('frontend/vendors/aos/dist/aos.css/aos.css') }}" />

    <!-- End plugin css for this page -->
    <link rel="shortcut icon" href=" {{ asset('frontend/images/favicon.png') }}" />

    <!-- inject:css -->
    <link rel="stylesheet" href=" {{ asset('frontend/css/style.css') }}">
    <!-- endinject -->
    {{-- <link rel="stylesheet" href="/css/app.css"> --}}
  </head>

  <body>
    <div id="app">
      <router-view></router-view>
      <!-- set progressbar -->
      <vue-progress-bar></vue-progress-bar>
    </div>
    
    <!-- inject:js -->
    <script src="{{ asset('frontend/vendors/js/vendor.bundle.base.js') }} "></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('frontend/vendors/aos/dist/aos.js/aos.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('frontend/js/demo.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.easeScroll.js') }}"></script>
    <!-- End custom js for this page-->
    <script src="{{ asset('/js/app.js') }}"></script>

  </body>
</html>
