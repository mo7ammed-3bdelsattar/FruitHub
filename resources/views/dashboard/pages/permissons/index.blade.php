<x-master-layout>
    @section('title','permissions')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                permissions Table
                <!-- 🔍 Filter Form -->
                <form id="filterForm" method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                </form>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create permissions
                </button>
            </h5>
            @include('dashboard.pages.permissons.create')
            <div class="table-responsive text-nowrap">
                <table class="table table-md align-middle mb-0 justify-content-between">
                    <caption class="ms-4">
                        List of permissions
                        <div class="mt-3">
                            {{ $permissions->appends(request()->query())->links() }}
                        </div>
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $permission->name }}</strong></td>
                            <td>

                                <a class="btn btn-warning"
                                    href="{{ route('dashboard.permissions.edit',$permission->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <form action="{{ route('dashboard.permissions.destroy',$permission->id) }}"
                                    class="d-inline" method="POST"
                                    onclick="return confirm('Are you sure you want to delete this permission?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
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