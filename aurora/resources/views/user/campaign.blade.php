@extends('layouts.user_type.auth')
@section('content')
@push('title')
<title>Aurora | Campaigns</title>
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



<div class="modal fade" id="campaign-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="slide-modal">
        <div class="modal-header">
          <h1 class="modal-title fs-5 create-campaign-title" id="staticBackdropLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn campaign-save-btn" id="">Create</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="campaign-delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Campaigns</h5>
                        </div>
                        <div class="campaign-control-btn-group">
                            <span id="refresh-campaign-row" title="Refresh"><svg
                                xmlns="http://www.w3.org/2000/svg" height="1em"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                  d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                              </svg></span>
                            <button class="btn bg-gradient-primary btn-sm mb-0" id="create-campaign-btn" type="button">Create Campaign</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive card-height p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Campaign Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Leads
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Schedule
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="campaigns">
                            {{-- @if ($campaignsLeads->isEmpty())
                                <tr>
                                    <td colspan="8">
                                        <div class="d-flex justify-content">
                                            <p class="text-md font-weight-bold mt-3 mx-auto">No Campaigns entry found in the System</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                            
                            @php
                                $i=0;
                            @endphp
                                @foreach ($campaignsLeads as $campaignLead )
                            @php
                                $i++;
                            @endphp
                                
                                @endforeach
                            @endif --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <nav>
          <ul class="pagination">
            <li class="page-item">
              <span class="page-link"><</span>
            </li>
            <li class="page-item">
              <span class="page-link">1</span>
            </li>
            <li class="page-item">
              <span class="page-link">2</span>
            </li>
            <li class="page-item">
              <span class="page-link">3</span>
            </li>
            <li class="page-item">
              <span class="page-link">></span>
            </li>
          </ul>
        </nav> --}}
    </div>
@endsection