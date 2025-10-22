<x-master-layout>
    @section('title','Roles')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                roles Table

                <a class="btn btn-primary btn-sm" href="{{ route('dashboard.roles.create') }}">
                    Create Role
                </a>
            </h5>
            {{-- @include('dashboard.pages.roles.create') --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-md align-middle mb-0 justify-content-between">
                    <caption class="ms-4">
                        List of roles
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $role->name }}</strong></td>
                            <td>
                                <a class="btn btn-warning" href="{{ route('dashboard.roles.edit',$role->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="btn btn-danger" href="{{ route('dashboard.roles.destroy',$role->id) }}">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @endsection
</x-master-layout>