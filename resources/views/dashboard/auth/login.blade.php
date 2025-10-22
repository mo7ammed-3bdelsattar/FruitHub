<!DOCTYPE html>


<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
  data-assets-path="{{ asset('dashboard/assets') }}/" data-template="vertical-menu-template-free">

@section('title', 'Login')
@include('dashboard.partials.auth.head')

<body>
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            @include('dashboard.partials.logo')
            <!-- /Logo -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <!-- Email Address -->
              <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email"
                  :value="old('email' )" autofocus autocomplete="username" placeholder="Enter your email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>

              <!-- Password -->
              {{-- <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full form-control" type="password" name="password"
                  autocomplete="current-password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div> --}}

              <div class="mt-4 mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <x-input-label for="email" :value="__('Email')" />
                  @if (Route::has('password.request'))
                  <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                  </a>
                  @endif
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />

                </div>
              </div>
              <!-- Remember Me -->
              <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                  <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                  <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
              </div>

              <div class="flex items-center justify-end mt-4">
                <x-primary-button class="btn btn-primary d-grid">
                  {{ __('Log in') }}
                </x-primary-button>
              </div>
            </form>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

  <!-- / Content -->

  <!-- Core JS -->
  @include('dashboard.partials.auth.scripts')
</body>

</html>