<?php
if(session('pagination') != null ){
session()->forget('pagination');
session(['pagination'=>\App\Models\Setting::first()->pagination]);
}
session(['pagination'=>\App\Models\Setting::first()->pagination])?>
<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('dashboard/assets') }}/"
  data-template="vertical-menu-template-free"
>
@include('dashboard.partials.header.head')
<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        @include('dashboard.partials.header.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

            @include('dashboard.partials.header.navigation')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            @yield('content')
            <!-- / Content -->

            <!-- Footer -->
            @include('dashboard.partials.footer.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    @include('dashboard.partials.footer.scripts')
  </body>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</html>
