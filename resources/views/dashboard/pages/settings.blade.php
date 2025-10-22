<x-master-layout>
    @section('title', content: __('Settings'))
    @section('content')
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ __('Application Settings') }} /</span> {{
                __('Edit') }}</h4>
            <div class="row">
                <div class="col-md-12">


                    <div class="card mb-4">
                        <h5 class="card-header">{{ __('Contantact & Linkes') }}</h5>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="formAccountSettings" action="{{ route('dashboard.settings.update') }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to apply this changes??')">
                                @csrf
                                @method("PATCH")
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="phone" class="form-label">{{ __('Phone 1') }}</label>
                                        <input class="form-control" type="text"
                                            value="{{ old('phone1',$settings->phone1 ) }}" id="phone1" name="phone1"
                                            autofocus />
                                        <x-input-error :messages="$errors->get('phone1')" class="mt-2" />

                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="phone2" class="form-label">{{ __('Phone 2') }}</label>
                                        <input class="form-control" type="text"
                                            value="{{ old('phone2',$settings->phone2 ) }}" id="phone2" name="phone2"
                                            autofocus />
                                        <x-input-error :messages="$errors->get('phone2')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">{{ __('E-mail') }}</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ old('email', $settings->email) }}"
                                            placeholder="john.doe@example.com" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 col-form-label"
                                            for="basic-icon-default-linkedin">linkedin</label>
                                        <input type="text" name="linkedin" id="basic-icon-default-linkedin"
                                            class="form-control" value="{{ old('linkedin',$settings->linkedin) }}"
                                            aria-describedby="basic-icon-default-linkedin" />
                                        <x-input-error :messages="$errors->get('linkedin')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 col-form-label"
                                            for="basic-icon-default-facebook">facebook</label>
                                        <input type="text" name="facebook" id="basic-icon-default-facebook"
                                            class="form-control" value="{{ old('facebook',$settings->facebook) }}"
                                            aria-describedby="basic-icon-default-facebook" />
                                        <x-input-error :messages="$errors->get('facebook')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 col-form-label"
                                            for="basic-icon-default-instagram">instagram</label>
                                        <input type="text" name="instagram" id="basic-icon-default-instagram"
                                            class="form-control" value="{{ old('instagram',$settings->instagram) }}"
                                            aria-describedby="basic-icon-default-instagram" />
                                        <x-input-error :messages="$errors->get('instagram')" class="mt-2" />
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 col-form-label"
                                            for="basic-icon-default-youtube">youtube</label>
                                        <input type="text" name="youtube" id="basic-icon-default-youtube"
                                            class="form-control" value="{{ old('youtube',$settings->youtube) }}"
                                            aria-describedby="basic-icon-default-youtube" />
                                        <x-input-error :messages="$errors->get('youtube')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 col-form-label"
                                            for="basic-icon-default-twitter">twitter</label>
                                        <input type="text" name="twitter" id="basic-icon-default-twitter"
                                            class="form-control" value="{{ old('twitter',$settings->twitter) }}"
                                            aria-describedby="basic-icon-default-twitter" />
                                            <x-input-error :messages="$errors->get('twitter')" class="mt-2" />
                                    </div>

                                </div>

                                <hr class="my-0" />
                                <h5 class="card-header">{{ __('Application Text') }}</h5>
                                <hr class="my-0" />
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 form-label" for="basic-icon-default-message">Home
                                            Text</label>
                                        <textarea name="home_text" id="aboutUs"
                                            class="form-control">{{ old('home_text',$settings->home_text) }}</textarea>
                                            <x-input-error :messages="$errors->get('home_text')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-md-4 form-label" for="basic-icon-default-message">Welcome
                                            Text</label>
                                        <textarea name="welcome_text" id="welcomeText"
                                            class="form-control">{{ old('welcome_text',$settings->welcome_text) }}</textarea>
                                            <x-input-error :messages="$errors->get('welcome_text')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 form-label" for="basic-icon-default-message">About
                                            us</label>
                                        <textarea name="about_us" id="aboutUs"
                                            class="form-control">{{ old('about_us',$settings->about_us) }}</textarea>
                                            <x-input-error :messages="$errors->get('about_us')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 form-label" for="basic-icon-default-message">Why
                                            us</label>
                                        <textarea name="why_us" id="whyUs"
                                            class="form-control">{{ old('why_us',$settings->why_us) }}</textarea>
                                            <x-input-error :messages="$errors->get('why_us')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 form-label" for="basic-icon-default-message">Goal</label>
                                        <textarea name="goal" id="goal"
                                            class="form-control">{{ old('goal',$settings->goal) }}</textarea>
                                            <x-input-error :messages="$errors->get('goal')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-2 form-label"
                                            for="basic-icon-default-message">Vision</label>
                                        <textarea name="vision" id="vision"
                                            class="form-control">{{ old('vision',$settings->vision) }}</textarea>
                                            <x-input-error :messages="$errors->get('vision')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-4 form-label" for="basic-icon-default-message">Success
                                            Text</label>
                                        <textarea name="success_text" id="success_text"
                                            class="form-control">{{ old('success_text',$settings->success_text) }}</textarea>
                                            <x-input-error :messages="$errors->get('success_text')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-4 form-label" for="basic-icon-default-message">Contact Us
                                            Text</label>
                                        <textarea name="contact_us_text" id="contact_us_text"
                                            class="form-control">{{ old('contact_us_text',$settings->contact_us_text) }}</textarea>
                                            <x-input-error :messages="$errors->get('contact_us_text')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-4 form-label" for="basic-icon-default-message">Terms
                                            Text</label>
                                        <textarea name="terms_text" id="terms_text"
                                            class="form-control">{{ old('terms_text',$settings->terms_text) }}</textarea>
                                            <x-input-error :messages="$errors->get('terms_text')" class="mt-2" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="col-sm-4 form-label"
                                            for="basic-icon-default-message">Pagination</label>
                                        <input name="pagination" id="pagination" class="form-control"
                                            value="{{ old('pagination',$settings->pagination) }}">
                                            <x-input-error :messages="$errors->get('pagination')" class="mt-2" />
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
                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    @endsection
</x-master-layout>