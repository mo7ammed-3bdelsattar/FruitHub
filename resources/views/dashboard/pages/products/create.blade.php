<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.products.store') }}" class="createModal" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Title</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="title" id="basic-icon-default-fullname"
                                    placeholder="Product 1" aria-label="Product 1"
                                    aria-describedby="basic-icon-default-fullname2" />
                                </div>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-description">Description</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <textarea name="description" id="basic-icon-default-description" class="form-control"
                                    placeholder="Product description"></textarea>
                                </div>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-price">price</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="number" name="price" id="basic-icon-default-price" class="form-control"
                                    placeholder="100" aria-describedby="basic-icon-default-price" />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-discount">Discount</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="number" name="discount" id="basic-icon-default-discount"
                                    class="form-control" placeholder="15%"
                                    aria-describedby="basic-icon-default-discount" />
                                </div>
                                <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-category_id">Category</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <select class="form-control" name="category_id" id="categorySelect">

                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="basic-icon-default-message">Tags</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge" id="tags">
                                <div class="form-control d-flex">

                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="inputGroupFile04"
                                aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" />
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
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

<script>
    function loadCategories(){
        fetch('/api/categories')
        .then(res => res.json())
        .then(response =>{
            const categories = response.data || response;
            const categorySelect = document.getElementById('categorySelect');
            categorySelect.innerHTML ='<option value="">-- Choose Category --</option>';
            categories.forEach(category => {
            categorySelect.innerHTML +=`<option value="${category.id}">${category.name}</option>`;
            });

        })
        .catch(err => console.error('Error loading categories:', err));
    }
    function loadTags(){
        fetch('/api/tags')
        .then(res => res.json())
        .then(response =>{
            const tags = response.data || response;
            const tagRadio = document.getElementById('tags');
            tagRadio.innerHTML ='';
            tags.forEach(tag => {
            tagRadio.innerHTML +=`<div class="form-check form-check-inline m-2">
                        <input class="form-check-input"
                            type="checkbox" name="tags[]" id="tag-${tag.id}"
                            value="${tag.id}">
                        <label class="form-check-label" for="tag-${tag.id}">
                            ${tag.name}
                        </label>
                    </div>`;
            });

        })
        .catch(err => console.error('Error loading tags:', err));
    }
    loadCategories();
    loadTags();
</script>

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('createModal'));
            myModal.show();
        });
    </script>
@endif