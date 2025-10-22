<x-master-layout>
    @section('title','Drivers')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                drivers Table
                <!-- 🔍 Filter Form -->
                <form id="filterForm" method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                </form>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create driver
                </button>
            </h5>
            @include('dashboard.pages.drivers.create')
            @include('dashboard.pages.drivers.edit')
            <div class="table-responsive text-nowrap">
                <table class="table table-sm align-middle mb-0">
                    <caption class="ms-4">
                        List of drivers
                        <div class="mt-3">
                            {{ $drivers->appends(request()->query())->links() }}
                        </div>
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $driver)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $driver->name }}</strong></td>
                            <td>{{ $driver->phone }}</td>
                            <td>
                                <button type="button" class="btn btn-primary"
                                    onclick="openEditModal({{ $driver->id }})">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </button>
                                <form action="{{ route('dashboard.drivers.destroy',$driver->id) }}" class="d-inline"
                                    method="POST"
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
    <script>
    function openEditModal(id) {
         fetch(`/dashboard/drivers/${id}/edit`)
        .then(res => res.json())
        .then(data => {

            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_phone').value = data.phone;

            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        });
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit_id').value;

    fetch(`/dashboard/drivers/${id}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: document.getElementById('edit_name').value,
            phone: document.getElementById('edit_phone').value,
        })
    })
    .then(data => {
        location.reload();
    })
    .catch(err => console.error(err));
});
    </script>

    @endsection
</x-master-layout>