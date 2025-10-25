<x-master-layout>
    @section('title','Orders')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                orders Table
                <!-- 🔍 Filter Form -->
                <form id="filterForm" method="GET" class="row g-3 align-items-center mb-4">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Status</option>
                            <option value="taken" {{ request('status')=='taken' ? 'selected' : '' }}>Taken</option>
                            <option value="preparing" {{ request('status')=='preparing' ? 'selected' : '' }}>
                                Preparing</option>
                            <option value="delivering" {{ request('status')=='delivering' ? 'selected' : '' }}>
                                Delivering</option>
                            <option value="received" {{ request('status')=='received' ? 'selected' : '' }}>
                                Received</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="date_range" class="form-select form-select-sm">
                            <option value="">Date</option>
                            <option value="today" {{ request('date_range')=='today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_range')=='yesterday' ? 'selected' : '' }}>
                                Yesterday</option>
                            <option value="last_7_days" {{ request('date_range')=='last_7_days' ? 'selected' : '' }}>
                                This Week</option>
                            <option value="last_30_days" {{ request('date_range')=='last_30_days' ? 'selected' : '' }}>
                                Last Month</option>
                            <option value="last_3_months" {{ request('date_range')=='last_3_months' ? 'selected' : ''
                                }}>Last 3 Months</option>
                            <option value="last_year" {{ request('date_range')=='last_year' ? 'selected' : '' }}>Last
                                Year</option>
                        </select>
                    </div>
                </form>
                <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary btn-sm">
                    Create Order
                </a>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-sm align-middle mb-0">
                    <caption class="ms-4">
                        List of orders
                        <div class="mt-3">
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Order Number</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Driver Name</th>
                            <th>Payment Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{ route('dashboard.orders.edit',$order->id) }}"><span
                                        class="badge bg-label-primary me-1">{{ $order->order_number }}</span></a></td>
                            <td>{{ $order->user->name }}</td>
                            <td> {{ $order->user->phone }} </td>
                            <td> <span class="badge bg-label-success me-1">{{ $order->total_price }}</span></td>
                            <td> <span class="badge bg-label-primary me-1">{{ $order->status }}</span></td>
                            <td><a href="{{ route('dashboard.drivers.index').'?search='.($order->driver->name ?? '') }}"><span class="badge bg-label-primary me-1">{{ $order->driver->name??''}}</span></a></td>
                            <td>
                                <span class="badge bg-label-{{ $order->payment_status =='paid'? 'success' : ($order->payment_status =='pending' ? 'warning' : 'danger') }} me-1">{{$order->payment_method .' , '. $order->payment_status }}</span>
                            </td>
                            <td> {{ $order->created_at->format('d/m H:i') ?? '' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('dashboard.orders.edit',$order->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard.orders.invoice',$order->id) }}">
                                            <i class="bx bx-printer"></i> Show Invoice
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard.orders.invoice.pdf',$order->id) }}">
                                            <i class="bx bx-printer"></i> Print Invoice
                                        </a>
                                        <form action="{{ route('dashboard.orders.destroy',$order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        const filterForm = document.getElementById('filterForm');
        document.querySelectorAll('#filterForm select').forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit();
            });
        });
        
        document.querySelectorAll('#filterForm input').forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    </script>
    @endsection
</x-master-layout>