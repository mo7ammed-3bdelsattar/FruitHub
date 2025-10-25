@extends('layouts.master')
@section('title', 'Orders')

@section('content')
<style>
    body {
        background-color: #f4f5fa;
        font-family: 'Public Sans', sans-serif;
    }

    .card {
        border: none;
        border-radius: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.2);
    }

    .btn-primary {
        background-color: #696CFF;
        border-color: #696CFF;
    }

    .btn-primary:hover {
        background-color: #5a5de0;
        border-color: #5a5de0;
    }

    .btn-success {
        background-color: #71DD37;
        border-color: #71DD37;
    }

    .btn-success:hover {
        background-color: #5ec52f;
        border-color: #5ec52f;
    }

    .btn-danger {
        background-color: #FF3E1D;
        border-color: #FF3E1D;
    }

    .btn-danger:hover {
        background-color: #e63819;
        border-color: #e63819;
    }

    .modal-content {
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.1);
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .table th {
        color: #566a7f;
    }

    .form-select {
        border-radius: 0.5rem;
    }

    .badge.bg-light.text-dark {
        background-color: #f1f2f6 !important;
        color: #333 !important;
    }

    h3,
    h5,
    h6 {
        color: #566a7f;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-4 text-center fw-bold">Select a Category</h3>

    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <button class="btn btn-primary btn-sm" onclick="loadProducts({{ $category->id }})">
                        View Products
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Products</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productsContainer" class="row g-4"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light border" data-bs-dismiss="modal">Continue Shopping</button>
                <button class="btn btn-primary" onclick="viewCart()">
                    View Cart <span class="badge bg-light text-dark" id="cartCount">0</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shopping Cart</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cartContainer"></div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <h6 class="mb-0">ShippingCost: <span id="cartShippingCost" class="fw-bold">0</span> EGP</h6>
                <h5 class="mb-0">subtotal: <span id="cartSubtotal" class="fw-bold">0</span> EGP</h5>
                <div>
                    <button class="btn btn-light border" data-bs-dismiss="modal">Back</button>
                    <button class="btn btn-primary" onclick="submitOrder()">Submit Order</button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="orderForm" method="POST" action="{{ route('dashboard.orders.store') }}">
    @csrf
</form>

@include('dashboard.pages.orders.scripts')

@endsection