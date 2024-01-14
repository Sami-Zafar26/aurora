<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>

@if (\Request::is('rtl'))
  <html dir="rtl" lang="ar">
@else
  <html lang="en" >
@endif

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @if (env('IS_DEMO'))
      <x-demo-metas></x-demo-metas>
  @endif


  @stack('title')
  {{-- <link rel="apple-touch-icon" sizes="76x76" href=""> --}}
  {{-- <link rel="icon" type="image/png" href=""> --}}
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/site.webmanifest">

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <script src="https://kit.fontawesome.com/75daafee80.js" crossorigin="anonymous"></script>

</head>

<body class="g-sidenav-show  bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }} ">
  @auth
    @yield('auth')
  @endauth
  @guest
    @yield('guest')
  @endguest

  {{-- @if(session()->has('success'))
    <div x-data="{ show: true}"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="position-fixed bg-success rounded right-3 text-sm py-2 px-4">
      <p class="m-0">{{ session('success')}}</p>
    </div>
  @endif --}}
    <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  @stack('rtl')
  @stack('dashboard')
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>


  <script src="{{asset('assets/js/jquery.js')}}"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> -->
  <!-- <script>let table = new DataTable('#myTable');</script> -->

  @stack('reupload-list')
  @stack('admin-ajax')
  @stack('tinymce')
  <script src="{{asset('assets/js/ajax.js')}}"></script>

  <script>
    $(document).ready(function () {
      $(".upload-existed-link").click(function () {
        $("#form-transition").addClass("active");
      });
      $("#form-back").click(function () {
        $("#form-transition").removeClass("active");
      });

      $(".manaully-lead-add").click(function () {
        $("#manaully-form-transition").addClass("active");
        // $(".modal-content.manaul").css("min-height","445px");
        $('.modal-content.manaul').attr('style','min-height:470px; transition:0.18s;');
      });
      $("#manaul-form-back").click(function () {
        $("#manaully-form-transition").removeClass("active");
        $('.modal-content.manaul').attr('style','height:470px; transition:0.18s;');
      });

    });

      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  </script>

</body>

</html>
