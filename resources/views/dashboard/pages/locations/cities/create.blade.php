<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dashboard.cities.store') }}" class="createModal" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-name">Name</label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="name" id="basic-icon-default-name"
                                    placeholder="Cairo" aria-label="John Doe"
                                    aria-describedby="basic-icon-default-name2" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-sm-4 col-form-label" for="basic-icon-default-shipping_cost">shipping cost</label>
                            <div class="input-group input-group-merge">
                                <input type="text" name="shipping_cost" id="basic-icon-default-shipping_cost" class="form-control"
                                    placeholder="5" aria-label="john.doe" />
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm justify-content-center">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>