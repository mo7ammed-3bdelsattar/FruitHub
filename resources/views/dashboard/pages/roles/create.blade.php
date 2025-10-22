<x-master-layout>
    @section('title','Create Role')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Fill New Role Data</h3>
            </div>
            <form action="{{route('dashboard.roles.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" class="form-control mb-4" required>
                    </div>

                    <div class="row mb-3">
                        @foreach($permissions as $permission)
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
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