<x-master-layout>
    @section('title','Edit User')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Basic with Icons</h5>
                    <div class="float-end">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addressesModal">
                            Addresses
                        </button>
                        <a class="btn btn-sm btn-warning my-2" href="{{ route('dashboard.users.role',$user->id) }}">
                            <i class="bx bx-edit-alt me-1"></i> Edit Role
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.users.update',$user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                                        id="basic-icon-default-fullname" placeholder="John Doe" aria-label="John Doe"
                                        aria-describedby="basic-icon-default-fullname2" />

                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        id="basic-icon-default-email" class="form-control"
                                        placeholder="john.doe@example.com" aria-label="john.doe"
                                        aria-describedby="basic-icon-default-email2" />

                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-phone">Phone</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                        id="basic-icon-default-phone" class="form-control" placeholder="+20123456789"
                                        aria-label="john.doe" aria-describedby="basic-icon-default-phone" />
                                </div>
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                    <input type="password" name="password" value="{{ $user->password }}"
                                        id="basic-icon-default-password" class="form-control" placeholder="********" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-message">Gender</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <div class="form-control d-flex">
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" {{ $user->gender? 'checked' : '' }}
                                            type="radio" name="gender" id="male"
                                            value="1">
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" {{ !$user->gender ? 'checked' :
                                            '' }} name="gender" id="female"
                                            value="0">
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />

                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-message">Is Admin?</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <div class="form-control d-flex">
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" {{ $user->is_admin? 'checked' : '' }}
                                            type="radio" name="is_admin" id="yes"
                                            value="1">
                                            <label class="form-check-label" for="yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="radio" {{ !$user->is_admin ? 'checked'
                                            : '' }} name="is_admin" id="yes"
                                            value="0">
                                            <label class="form-check-label" for="yes">No</label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('is_admin')" class="mt-2" />

                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" />
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                    @include('dashboard.pages.locations.addresses.show')
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-master-layout>