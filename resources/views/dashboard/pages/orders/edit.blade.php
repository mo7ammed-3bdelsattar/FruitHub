<x-master-layout>
    @section('title','Edit Order')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ __('Info for ').$order->order_number }}</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productsModal">
                        Products
                    </button>
                </div>
                <div class="card-body">

                    <div class="">
                        <p><strong>{{ __('Client Name:') }}</strong> {{ $order->user->name }}</p>
                        <p><strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('Y-m-d h:i A') }}</p>
                    </div>
                    <hr class="my-0" />
                    <div class="my-4">
                        <p>{{ __('Current status : ') }} {{ $order->status }}</p>
                        <p>{{ __('subtotal : ') }} {{ $order->subtotal_price }} {{ __(' LE') }}</p>
                        <p>{{ __('Shipping Cost : ') }} {{ $order->total_price - $order->subtotal_price }} {{ __(' LE')
                            }}</p>
                        <h2 class="badge me-1" style="background-color: #000; color: #fff; text-align: center;">{{
                            __('Total: ') }}
                            {{ $order->total_price }} {{ __(' LE') }}</h2>
                    </div>

                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Statuses Table
                    <!-- 🔍 Filter Form -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                        Update Status
                    </button>

                    @include('dashboard.pages.orders.add-status')
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm align-middle mb-0">
                        <caption class="ms-4">
                            List Of Statuses
                        </caption>
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderTrackings as $traker)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><span class="badge bg-label-primary me-1">{{ $order->order_number }}</span></td>
                                <td> {{ $traker->status }} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ __('Edit ')}}</h5>
                    @if($order->payment_method == 'online' && $order->payment_statud == 'paid')
                    <form action="{{ route('dashboard.orders.update',$order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <input type="text" name="payment_method" id="" value="online" hidden>
                        <button class="btn btn-sm btn-primary">
                            Pay
                        </button>
                    </form>
                    @endif
                </div>  
                <div class="card-body">
                    <form action="{{ route('dashboard.orders.update',$order->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Driver</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                    <select name="driver_id" id="" class="form-control">
                                        <option value="">--Select Driver--</option>
                                        @foreach ($drivers as $driver )
                                        <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id
                                            ?'selected': '' }}>{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Payment
                                Status</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-dollar"></i></span>
                                    <select name="payment_status" id="" class="form-control">
                                        <option value="">--Select Status--</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ?'selected': '' }}>Paid
                                        </option>
                                        <option value="pending" {{ $order->payment_status == 'pending' ?'selected': ''
                                            }}>pending</option>
                                        <option value="failed" {{ $order->payment_status == 'failed' ?'selected': ''
                                            }}>failed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                    <div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productsModalLabel">Products</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-sm align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->products as $product)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td><strong>{{ $product->title }}</strong></td>
                                                    <td><span class="badge bg-label-primary me-1">{{ $product->price
                                                            }}$</span></td>
                                                    <td>
                                                        <form
                                                            action="{{ route('dashboard.orders.item.delete',['orderId'=>$order->id , 'productId'=>$product->id]) }}"
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
                </div>
            </div>

        </div>
    </div>
    @endsection
</x-master-layout>