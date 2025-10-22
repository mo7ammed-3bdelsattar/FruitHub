<x-master-layout>
    @section('title', content: __('Profile'))
    @section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ __('Account Settings') }} /</span> {{
                __('Account') }}</h4>
            @include('dashboard.auth.confirm-password')

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                {{ __('Account') }}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                    class="bx bx-bell me-1"></i> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-connections.html"><i
                                    class="bx bx-link-alt me-1"></i> Connections</a>
                        </li> --}}
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">{{ __('Profile Details') }}</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ App\Helpers\FileHelper::get_file_path(auth()->user()->image?->path,'user') }}"
                                    alt="user-avatar" class="d-block rounded-circle" height="100" width="100"
                                    id="uploadedAvatar" />
                                <form action="{{ route('dashboard.profile.updateImage') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')


                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input" hidden
                                                name="image" />
                                        </label>
                                        <button type="submit"
                                            class="btn btn-outline-secondary account-image-reset mb-4">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </form>
                                @if(auth()->user()->image)
                                <form action="{{ route('dashboard.profile.destroyImage') }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Delete</span>
                                    </button>
                                </form>
                                @endif
                                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" action="{{ route('dashboard.profile.update') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to apply this changes??')">
                            @csrf
                            @method("PATCH")
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}" autofocus />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        placeholder="john.doe@example.com" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-phone">Phone</label>
                                    <input type="text" name="phone" id="basic-icon-default-phone" class="form-control"
                                        placeholder="+20123456789" value="{{ auth()->user()->phone }}"
                                        aria-describedby="basic-icon-default-phone" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="col-sm-2 col-form-label"
                                        for="basic-icon-default-password">Password</label>
                                    <input type="password" name="password" id="basic-icon-default-password"
                                        class="form-control" placeholder="********" />
                                </div>
                            </div>

                            {{-- <div class="mb-3 col-md-6">
                                <label class="form-label" for="country">{{ __('Country') }}</label>
                                <select id="country" class="select2 form-select">
                                    <option value="" selected>{{ __('Egypt') }}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="language" class="form-label">{{ __('Language') }}</label>
                                <select id="language" class="select2 form-select">
                                    <option value="">{{ __('Select Language') }}</option>
                                    <option value="en">{{ __('English') }}</option>
                                    <option value="ar">{{ __('Arabic') }}</option>
                                </select>
                            </div> --}}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="col-sm-2 form-label" for="basic-icon-default-message">Gender</label>
                                    <div class="form-control d-flex">
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" {{ (auth()->user()->gender)
                                            ?'checked': '' }} name="gender" id="male"
                                            value="1">
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" {{ (!auth()->user()->gender )
                                            ?'checked': '' }} name="gender" id="female"
                                            value="0">
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">{{ __('Save changes') }}</button>
                                <button type="reset" class="btn btn-outline-secondary">{{ __('Cancel') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                <div class="card">
                    <h5 class="card-header">{{ __('Delete Account') }}</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading fw-bold mb-1">{{ __('Are you sure you want to delete your
                                    account?') }}
                                </h6>
                                <p class="mb-0">{{ __('Once you delete your account, there is no going back. Please
                                    be
                                    certain.') }}</p>
                            </div>
                        </div>
                        <button class="btn btn-danger deactivate-account" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">{{
                            __('Deactivate
                            Account')
                            }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
    </div>
    @endsection
</x-master-layout>