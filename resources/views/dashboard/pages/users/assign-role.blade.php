<x-master-layout>
    @section('title','Assign Role To User')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Basic with Icons</h5>
                    <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.users.role',$user->id) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="basic-icon-default-message">Role</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <div class="form-control d-flex">
                                    @foreach ($roles as $role)
                                    <div class="form-check form-check-inline m-2">
                                        <input class="form-check-input" type="radio" name="role" id="role" {{ $user->hasRole($role->name)?'checked':'' }} value="{{ $role->name }}">
                                        <label class="form-check-label" >{{ ucfirst($role->name) }}</label>
                                    </div>                                        
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-master-layout>