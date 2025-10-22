<x-master-layout>
    @section('title','Edit Role')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Role Data</h3>
            </div>
            <form action="{{route('dashboard.roles.update',$role->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control mb-4" required>
                    </div>

                    <div class="row mb-3">
                        @foreach($permissions as $permission)
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
    </div>
    @endsection
</x-master-layout>