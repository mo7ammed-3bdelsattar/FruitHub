<x-master-layout>
    @section('title','Users')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                users Table
                <!-- 🔍 Filter Form -->
                <form id="filterForm" method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                </form>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create User
                </button>
            </h5>
            @include('dashboard.pages.users.create')
            <div class="table-responsive text-nowrap">
                <table class="table table-sm align-middle mb-0">
                    <caption class="ms-4">
                        List of users
                        <div class="mt-3">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Role</th>
                            @canany(['edit users','delete users'])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <img src="{{ App\Helpers\FileHelper::get_file_path($user->image?->path,'user') }}"
                                    alt="Image" width="40" height="40" class="rounded-circle">
                            </td>
                            <td><span
                                    class="badge bg-label-{{ $user->hasRole('admin')? 'danger' : ($user->hasRole('manager')? 'warning' : 'primary') }} me-1">{{
                                    $user->roles->first()->name?? '' }}</span></td>
                            @canany(['edit users','delete users'])
                            <td>
                                <a class="btn btn-sm btn-warning" href="{{ route('dashboard.users.edit',$user->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <form action="{{ route('dashboard.users.destroy',$user->id) }}" class=" d-inline"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>

                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    !-- ⚙️ JavaScript -->
    <script>
        const filterForm = document.getElementById('filterForm');
        // auto submit on change
        document.querySelectorAll('#filterForm input').forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    </script>
    @endsection
</x-master-layout>