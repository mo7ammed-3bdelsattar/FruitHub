<x-master-layout>
    @section('title','cities')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                cities Table

                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create City
                </button>
            </h5>
            @include('dashboard.pages.locations.cities.create')
            @include('dashboard.pages.locations.cities.edit')
            <div class="table-responsive text-nowrap">
                <table class="table table-md align-middle mb-0 justify-content-between">
                    <caption class="ms-4">
                        List of cities
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Shipping Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $city->name }}</strong></td>
                            <td>{{ $city->shipping_cost }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="openEditModal({{ $city->id }})">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </button>
                                <form action="{{ route('dashboard.cities.destroy',$city->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this city?')">
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

    <script>
        function openEditModal(id) {
    fetch(`/dashboard/cities/${id}/edit`)
        .then(res => {
            if (!res.ok) throw new Error('Failed to fetch city data');
            return res.json();
        })
        .then(response => {
            const data = response.data || response;
            const form = document.getElementById('editForm');
            
            // Set form action dynamically
            form.action = `/dashboard/cities/${data.id}`;
            
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_shipping_cost').value = data.shipping_cost || data.shippingCost;
            
            const myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        })
        .catch(err => {
            console.error('Error loading city data:', err);
            alert('Failed to load city data');
        });
}
// Form submits normally without JavaScript interception
    </script>

    @endsection
</x-master-layout>