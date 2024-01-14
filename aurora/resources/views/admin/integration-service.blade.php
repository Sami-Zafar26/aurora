@extends('layouts.user_type.auth')
@push('title')
  <title>Aurora | Integration Service</title>
@endpush
@section('content')

<div class="modal fade" id="integration-service-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn integration-service-save-btn" id="">Create</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="integration-service-delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Campaign</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <p class="font-weight-bold mb-0">Are you sure you want to delete this Campaign?</p>
          <input type="hidden" id="campaign-token" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger delete">Delete</button>
        </div>
    </div>
  </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-height">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">All Integration Services</h6>
                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0" id="create-integration-service-btn">Create Service</button>
                    </div>
                </div>
                <hr class="mt-3 mb-0">
                <div class="card-body pt-4 p-3">
                  <ul class="list-group">
                    <div class="row">
                      @if ($integration_services->isEmpty())
                      <div class="d-flex justify-content-center">
                        <h6 class="mb-0 text-sm"><a href="#" class="text-muted">No Integration service entry found in the System</a></h6>
                        {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                      </div>
                      @else
                      
                      {{-- @foreach ($integration_credentials as $key => $integration_credential)  
                        @php       
                        $value = json_decode($integration_credential->json_field_value,true);
                        @endphp --}}
                                {{-- <div class="col-md-6">
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
                                      @endforeach
                                    </div>
                                    <div class="ms-auto text-end">
                                      <button class="integration-credential-delete btn btn-link text-danger text-gradient px-3 mb-0" data-integration-credential-token={{$integration_credential->credential_token}}><i class="far fa-trash-alt me-2"></i>Delete</button>
                                      <button class="integration-credential-edit btn btn-link text-dark px-3 mb-0" data-integration-credential-token={{$integration_credential->credential_token}}><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</button>
                                    </div>
                                  </div>
                                </li>
                       @endforeach --}}
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
        </div>
    </div>


    @push('admin-ajax')
        <script src="{{asset('assets/js/admin-ajax.js')}}"></script>
    @endpush
@endsection