<x-master-layout>
    @section('title','Edit Product')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic with Icons -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Basic with Icons</h5>
                    <small class="text-muted float-end">Merged input group</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.products.update',$product->id) }}" class="createModal" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Title</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="title"
                                        id="basic-icon-default-fullname" placeholder="Product 1" value="{{ old('title',$product->title) }}" aria-label="Product 1"
                                        aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"
                                for="basic-icon-default-description">Description</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <textarea name="description" id="basic-icon-default-description"
                                        class="form-control" placeholder="Product description">{{ old('description',$product->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-price">price</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="price" id="basic-icon-default-price" class="form-control"
                                        placeholder="100" aria-describedby="basic-icon-default-price" value="{{ old('price',$product->price) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-discount">Discount</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="discount" id="basic-icon-default-discount"
                                        class="form-control" placeholder="15%"
                                        aria-describedby="basic-icon-default-discount" value="{{ old('discount',$product->discount) }}" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-category_id">Category</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <select class="form-control" name="category_id" id="categorySelect">
                                        <option value="">--Select Category--</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id
                                            ?'selected' : '' }}> {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-message">Tags</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge" id="tags">
                                    <div class="form-control ">
                                        @foreach ($tags as $tag)
                                        <div class="form-check form-check-inline m-2">
                                            <input class="form-check-input" type="checkbox" name="tags[]"
                                                 value="{{ $tag->id }}"   {{ (in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray()))) ? 'checked' : '' }}>
                                            <label class="form-check-label" >
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-master-layout>