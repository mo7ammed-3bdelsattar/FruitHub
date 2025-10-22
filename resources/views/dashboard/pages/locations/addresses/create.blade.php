<x-master-layout>
    @section('title','Create Address')
    @section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">New Address For <strong>{{ $user->name }}</strong></h3>
            </div>
            <div class="card-body">
                <form action="{{route('dashboard.addresses.user.store',$user->id)}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">{{ __('City') }}</label>
                            <select name="city_id" id="" class="form-control">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="street" class="form-label">{{ __('Street') }}</label>
                            <input class="form-control" type="text" id="street" name="street"
                                value="{{ old('street') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="building" class="form-label">{{ __('Building') }}</label>
                            <input class="form-control" type="text" id="building" name="building"
                                value="{{ old('building') }}" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="floor" class="form-label">{{ __('Floor') }}</label>
                            <input class="form-control" type="text" id="floor" name="floor"
                                value="{{ old('floor') }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="apartment" class="form-label">{{ __('apartment') }}</label>
                            <input class="form-control" type="text" id="apartment" name="apartment"
                                value="{{ old('apartment') }}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    @endsection
</x-master-layout>