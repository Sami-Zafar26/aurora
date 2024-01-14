@extends('layouts.user_type.auth')
@push('title')
  <title>Aurora | Package</title>
@endpush
@section('content')
    <div id="toasty-success-message">
        <div class="toasty">
        <img src="{{asset('assets/img/icons/success.png')}}" alt="" class="toasty-icon">
        <div class="message">
            <h2>Success</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
        <button class="close-btn">
            <img src="{{asset('assets/img/icons/cross.png')}}" alt="" class="close-icon">
        </button>
        </div>
    </div>
    <div id="toasty-error-message">
        <div class="toasty">
        <img src="{{asset('assets/img/icons/warning.png')}}" alt="" class="toasty-icon">
        <div class="message">
            <h2>Error</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </div>
        <button type="button" class="close-btn">
            <img src="{{asset('assets/img/icons/cross.png')}}" alt="" class="close-icon">
        </button>
        </div>
    </div>

    <div class="package-control d-flex justify-content-end mb-3">
        <button type="button" data-bs-toggle="modal" data-bs-target="#create-package-modal" class="btn btn-sm bg-gradient-info">Make Package</button>
    </div>

    <div class="modal fade" id="create-package-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Make Package</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="create-package-form">
            @csrf
          <div class="modal-body">
            <div class="mb-3">
                <label for="">Package Name</label>
                <input type="text" class="form-control" name="package_name" id="" placeholder="Package Name...">
            </div>
            <div class="mb-3">
                <label for="">Compaign Allowed</label>
                <input type="number" class="form-control" name="compaign_allowed" id="" placeholder="Compaign Allowed...">
            </div>
            <div class="mb-3">
                <label for="">Lead Allowed</label>
                <input type="number" class="form-control" name="lead_allowed" id="" placeholder="Lead Allowed...">
            </div>
            <div class="mb-3">
                <label for="">Package Duration</label>
                <input type="number" class="form-control" name="package_duration" id="" placeholder="Package Duration...">
            </div>
            <div class="mb-3">
                <label for="">Package Price</label>
                <input type="number" class="form-control" name="package_price" id="" placeholder="Package Price...">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary update" id="list-update-btn">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    <div class="modal fade" id="edit-package-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Make Package</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit-package-form">
            @csrf
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary update" id="list-update-btn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    @foreach ( $packages as $package )
    <div class="col-md-4 col-sm-12">
        <div class="pricing-card basic">
            {{-- <div class="head">Current Plan</div> --}}
            <h3 id="package_name">{{$package->package_name}}</h3>
            <h1 id="package_price">${{$package->package_price}}</h1>
            <ul>
                <li>{{$package->compaign_allowed}} Compaign Allowed</li>
                <li>{{$package->lead_allowed}} Lead Allowed</li>
                <li>For {{$package->package_duration}} Months</li>
            </ul>
            <button type="button" class="subscribe">Subscribe</button><br>
            <div class="package-btn-group">
                <button type="button" class="package-info-btn mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                </button>
                <button type="button" class="edit-package mt-2" data-package-token="{{$package->token}}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                </button>
                <button type="button" class="delete-package mt-2" data-package-token="{{$package->token}}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                </button>
            </div>
        </div>
    </div>
    @endforeach
  </div>

@push('admin-ajax')
    <script src="{{asset('assets/js/admin-ajax.js')}}"></script>
@endpush
@endsection