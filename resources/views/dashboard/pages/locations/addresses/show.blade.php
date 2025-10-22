<div class="modal fade" id="addressesModal" tabindex="-1" aria-labelledby="addressesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressesModalLabel">Addresses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a href="{{ route('dashboard.addresses.user.create',$user->id) }}" class="btn btn-sm btn-primary">Add Address</a>
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>City</th>
                                <th>Street</th>
                                <th>Building</th>
                                <th>Floor</th>
                                <th>Apartment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->addresses as $address)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><strong>{{ $address->city->name }}</strong></td>
                                <td>{{ $address->street }}</td>
                                <td>
                                    {{ $address->building }}
                                </td>
                                <td>{{ $address->floor }}</td>
                                <td>{{ $address->apartment }}</td>
                                <td>
                                    <form
                                        action="{{ route('dashboard.addresses.destroy',$address->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>