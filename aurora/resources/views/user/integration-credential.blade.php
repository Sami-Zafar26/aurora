@extends('layouts.user_type.auth')
@section('content')
@push('title')
    <title>Aurora | Integration Credentials</title>
@endpush

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

<div class="modal fade" id="credential-delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Credential</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
      <div class="modal-body">
        <p class="font-weight-bold mb-0">Are you sure you want to delete this integration credential?</p>
        <input type="hidden" id="integration-credential-token" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger integration-credential-delete-btn">Delete</button>
      </div>
  </div>
</div>
</div>

{{-- <div class="modal fade" id="credential-edit-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Credential</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="update-integration-credential-form">
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success integration-credential-edit-btn" id="update-integration-credential-btn">Update</button>
      </div>
    </form>
  </div>
</div>
</div> --}}

<div class="modal modally fade" id="integration-credential-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="staticBackdropLabel">Integration Credential</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form>
      <div class="modal-body">

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn integration-credential-edit-btn" id="">Save</button>
      </div>
    </form>
  </div>
</div>
</div>

    {{-- <div class="modal fade" id="create-integration-credential-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create Integration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="service-box">
                        @foreach ($integration_services as $integration_service)
                            <div class="integration-service-logo-cover integration-services" data-service-token="{{$integration_service->token}}">
                              <img src="{{asset($integration_service->logo_location)}}" alt="">                            
                              <h6>Smtp</h6>
                            </div>
                        @endforeach
                    </div>
                    <form id="create-integration-credential-form">
                      @csrf
                        <div id="fields-wrapper" class="mt-2">
                            
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="save-integration-credential-btn">Save</button>
                </div>
                    </form>
            </div>
        </div>
    </div> --}}

    {{-- integration services code --}}
    {{-- <div class="integration-service-logo-cover integration-services" data-service-token="{{$integration_service->token}}">
      <img src="{{asset($integration_service->logo_location)}}" alt="">                            
      <h6>Smtp</h6>
    </div> --}}
    {{-- <form id="create-integration-credential-form">
      @csrf
        <div id="fields-wrapper" class="mt-2">
            
        </div> --}}

<div class="row">
    <div class="col-md-12">
      <div class="card card-height">
        <div class="card-header pb-0 px-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">All Integrations</h6>
                <button type="button" class="btn btn-sm bg-gradient-primary mb-0" id="create-integration-credential-btn">Create Integration</button>
            </div>
        </div>
        <hr class="mt-3 mb-0">
        <div class="card-body pt-4 p-3">
          <ul class="list-group">
            <div class="row">
              @if ($integration_credentials->isEmpty())
              <div class="d-flex justify-content-center">
                <h6 class="mb-0 text-sm"><a href="#" class="text-muted">No Integration credentials entry found in the System</a></h6>
                {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
              </div>
              @else
              
              @foreach ($integration_credentials as $key => $integration_credential)  
                @php       
                $value = json_decode($integration_credential->json_field_value,true);
                @endphp
                        <div class="col-md-6">
                          <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                              <h6 class="mb-3 text-sm">{{$integration_credential->service_name}}</h6>
                              @foreach ($value as $valueinner ) 
                              @if ($valueinner['label'] === 'Mail Username')
                              <span class="mb-2 text-xs">{{$valueinner['label']}}:<span class="text-dark font-weight-bold ms-sm-2">{{substr($valueinner['value'],0,20)}}...</span></span>
                              @elseif ($valueinner['label'] === 'Mail Password')
                              <span class="mb-2 text-xs">{{$valueinner['label']}}:<span class="text-dark font-weight-bold ms-sm-2">{{substr($valueinner['value'],0,3)}}********</span></span>
                              @else
                              <span class="mb-2 text-xs">{{$valueinner['label']}}:<span class="text-dark font-weight-bold ms-sm-2">{{$valueinner['value']}}</span></span>
                              
                              @endif
                              {{-- <span class="mb-2 text-xs">{{$valueinner['name']}}<span class="text-dark ms-sm-2 font-weight-bold">{{$valueinner['value']}}</span></span> --}}
                              {{-- <span class="mb-2 text-xs">{{$valueinner['name']}}<span class="text-dark ms-sm-2 font-weight-bold">{{$valueinner['value']}}</span></span> --}}
                              {{-- <span class="mb-2 text-xs">{{$valueinner['name']}}<span class="text-dark ms-sm-2 font-weight-bold">{{$valueinner['value']}}</span></span> --}}
                              {{-- <span class="mb-2 text-xs">{{$valueinner['name']}}<span class="text-dark ms-sm-2 font-weight-bold">{{$valueinner['value']}}</span></span> --}}
                              @endforeach
                            </div>
                            {{-- @continue --}}
                            <div class="ms-auto text-end">
                              <button class="integration-credential-delete btn btn-link text-danger text-gradient px-3 mb-0" data-integration-credential-token={{$integration_credential->credential_token}}><i class="far fa-trash-alt me-2"></i>Delete</button>
                              <button class="integration-credential-edit btn btn-link text-dark px-3 mb-0" data-integration-credential-token={{$integration_credential->credential_token}}><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</button>
                            </div>
                          </div>
                        </li>
               @endforeach
               @endif
                {{-- <div class="col-md-6">            
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Mail Trap</h6>
                            <span class="mb-2 text-xs">Company Name: <span class="text-dark font-weight-bold ms-sm-2">Stone Tech Zone</span></span>
                            <span class="mb-2 text-xs">Email Address: <span class="text-dark ms-sm-2 font-weight-bold">lucas@stone-tech.com</span></span>
                            <span class="text-xs">VAT Number: <span class="text-dark ms-sm-2 font-weight-bold">FRB1235476</span></span>
                        </div>
                        <div class="ms-auto text-end">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                        </div>
                    </li>
                </div> --}}
            </div>
          </ul>
        </div>
      </div>
    </div>



    {{-- <div class="col-md-5 mt-4">
      <div class="card h-100 mb-4">
        <div class="card-header pb-0 px-3">
          <div class="row">
            <div class="col-md-6">
              <h6 class="mb-0">Your Transaction's</h6>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
              <i class="far fa-calendar-alt me-2"></i>
              <small>23 - 30 March 2020</small>
            </div>
          </div>
        </div>
        <div class="card-body pt-4 p-3">
          <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                  <span class="text-xs">27 March 2020, at 12:30 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                - $ 2,500
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Apple</h6>
                  <span class="text-xs">27 March 2020, at 04:30 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 2,000
              </div>
            </li>
          </ul>
          <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Yesterday</h6>
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Stripe</h6>
                  <span class="text-xs">26 March 2020, at 13:45 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 750
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">HubSpot</h6>
                  <span class="text-xs">26 March 2020, at 12:30 PM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 1,000
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Creative Tim</h6>
                  <span class="text-xs">26 March 2020, at 08:30 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                + $ 2,500
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation"></i></button>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                  <span class="text-xs">26 March 2020, at 05:00 AM</span>
                </div>
              </div>
              <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                Pending
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div> --}}
@endsection