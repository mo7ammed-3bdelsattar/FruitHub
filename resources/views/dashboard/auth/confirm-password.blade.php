<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Logo -->
                @include('dashboard.partials.logo')
                <!-- /Logo -->


                <form method="POST" id="formAccountDeactivation" action="{{ route('dashboard.profile.destroy') }}"
                    onsubmit="return confirm('Are you sure you want to delete your account😢?')">
                    @csrf
                    @method('DELETE')
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full form-control" type="password"
                            name="password" required autocomplete="current-password" />

{{ $user->gender? 'checked' : '' }}                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button class="btn btn-primary d-grid">
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>