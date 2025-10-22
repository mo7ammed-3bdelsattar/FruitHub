<x-master-layout>
    @section('title','Products')
    @section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Products Table

                <!-- 🔍 Filter Form -->
                <form id="filterForm" method="GET" class="row g-3 align-items-center mb-2">
                    <div class="col-auto">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-auto">
                        <select name="categoryId" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('categoryId')==$category->id ? 'selected' :
                                '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <select name="tagId" class="form-select form-select-sm">
                            <option value="">All Tags</option>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ request('tagId')==$tag->id ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 🎚️ Price Range Sliders -->
                    <div class="col-auto d-flex flex-column">
                        <label class="form-label mb-1 small d-flex">Min: <span id="minPriceValue">{{ request('minPrice',
                                0) }}</span>$</label>
                        <input type="range" name="minPrice" id="minPrice" class="form-range" min="0" max="1000"
                            step="10" value="{{ request('minPrice', 0) }}" style="width: 150px;">
                    </div>

                    <div class="col-auto d-flex flex-column">
                        <label class="form-label mb-1 small">Max: <span id="maxPriceValue">{{ request('maxPrice', 1000)
                                }}</span>$</label>
                        <input type="range" name="maxPrice" id="maxPrice" class="form-range" min="0" max="1000"
                            step="10" value="{{ request('maxPrice', 1000) }}" style="width: 150px;">
                    </div>
                </form>
                @can('create products')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create Product
                </button>
                @endcan
            </h5>
            @include('dashboard.pages.products.create')
            <div class="table-responsive text-nowrap">
                <table class="table table-sm align-middle mb-0">
                    <caption class="ms-4">
                        List of Products
                        <div class="mt-3">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </caption>
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>tags</th>
                            @canany(['edit products','delete products'])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><strong>{{ $product->title }}</strong></td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                <img src="{{ App\Helpers\FileHelper::get_file_path($product->image?->path,'') }}"
                                    alt="Image" width="40" height="40" class="rounded-circle">
                            </td>
                            <td><span class="badge bg-label-primary me-1">{{ $product->price }}$</span></td>
                            <td>{{ Str::limit($product->description, 40) }}</td>
                            <td>@foreach ($product->tags->take(1) as $tag)
                                <a href="?tag={{ $tag->id }}"><span class="badge bg-label-info me-1">{{ $tag->name
                                        }}</span></a>
                                @endforeach
                            </td>
                            @canany(['edit products','delete products'])
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="{{ route('dashboard.products.edit',$product->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                            @endcanany
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- ⚙️ JavaScript -->
    <script>
        const filterForm = document.getElementById('filterForm');
        const minPrice = document.getElementById('minPrice');
        const maxPrice = document.getElementById('maxPrice');
        const minPriceValue = document.getElementById('minPriceValue');
        const maxPriceValue = document.getElementById('maxPriceValue');

        minPrice.addEventListener('input', () => {
            minPriceValue.textContent = minPrice.value;
        });
        maxPrice.addEventListener('input', () => {
            maxPriceValue.textContent = maxPrice.value;
        });


        // auto submit on change
        document.querySelectorAll('#filterForm input').forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    

    // auto submit on change
    document.querySelectorAll('#filterForm select').forEach(input => {
    input.addEventListener('change', () => {
    filterForm.submit();
    });
    });
    </script>

    @endsection
</x-master-layout>