@extends('layouts.user_type.auth')
@section('content')

@push('title')
  <title>Aurora | Leads</title>
@endpush

<!-- Button trigger modal -->

{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button> --}}

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

<!-- Modal -->

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Lead Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="lead-detail">
        
      </div>
      <div class="modal-footer">
        <button type="button" id="close-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Lead</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="update-form">
        <div class="modal-body pb-1" id="edit-lead">

          <div class="reference"></div>
          <button type="button" class="additional-attribute-btn btn btn-sm btn-info my-2">Additional Attribute</button>

        </div>

        <div class="modal-footer">
          <button type="button" id="close-edit-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary update">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="custom-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        {{-- <div class="list-add">

        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Lead</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form id="manaul-form">
                @csrf
                <label for="list_name" class="col-sm-4 form-label">List Name</label>
                <div class="d-flex list-add-group">
                  <div class="col-sm-12">
                    <input type="text" class="form-control" name="list_name" id="manaully_list_name"
                      placeholder="List Name...">
                  </div>
                </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <label for="list_description" class="form-label">Description about list (Optional)</label>
                <textarea name="list_description" id="manaully_list_description" class="form-control" cols="30" rows="4"
                placeholder="Description here..."></textarea>
              </div>
            </div>
            <div class="link-group mt-3">
              <button type="submit" class="btn btn-primary btn-sm add-list-button m-0">Add</button>
              <a href="#" class="manaully-lead-add" >Choose List?</a>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div> --}}


        {{-- <div class="single-lead-add"> --}}
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Lead</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="manaully-user-add">
              @csrf
              <div class="col-md-12">
                <div class="mb-1">
                  <label for="inputPassword" class="col-sm-4 form-label">Choose List</label>
                  <select id="select-list" name="list_token" class="form-select" aria-label="Default select example"></select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-1">
                    <label for="first_name" class="form-label">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" placeholder="First Name...">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-1">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Last Name...">
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email...">
              </div>
              <div class="reference"></div>
              <button type="button" class="additional-attribute-btn btn btn-sm btn-info my-2">Additional Attribute</button>
              <br>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="add-lead-close-btn" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="upload-manual-btn" class="btn btn-primary">Save</button>
          </div>
        </form>
        {{-- </div> --}}

      </div>
    </div>
  </div>

  <div class="modal fade" id="lead-deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete List</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <p class="font-weight-bold mb-0">Are you sure you want to delete this list?</p>
            <input type="hidden" id="lead-token" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger delete">Delete</button>
          </div>
      </div>
    </div>
  </div>


{{-- <div class="allowed-wrapper">
  <div class="allowed-box">
    <p>{{$userleads_count}}/ {{$lead_allowed->lead_allowed}}</p>
    <p>(current/ allowed)</p>
  </div>
</div> --}}

    <div class="row">
        <div class="col-12">
          <div class="card card-height mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6 class="m-0">All Leads</h6>
              <div class="list-leads-header-group">
                <div class="add-btn-group">
                  <button class="btn btn-sm btn-dark mb-0" data-bs-toggle="modal" data-bs-target="#custom-add">Add Lead</button>
                </div>
              <div class="search-box">
                <form action="{{route('leads')}}" method="get" class="search-form">
                  @if (isset($search))
                  <input type="search" class="form-control form-control-sm" name="search_query" id="" placeholder="Search..." value="{{$search}}">
                  @else
                  <input type="search" class="form-control form-control-sm" name="search_query" id="" placeholder="Search...">
                  @endif
                  <input type="submit" class="btn btn-sm btn-info m-0" value="Search">
                </form>
              </div>
            </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sr.#</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Name</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if ($userLeads->isEmpty())
                    <tr>
                      <td colspan="9">
                        <div class="d-flex px-2 py-3 justify-content-center">
                          <div class="file-icon mx-2">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-lg text-center"><a href="#" class="text-muted">No User Leads entry found in the System</a></h6>
                            <p class="text-md text-secondary mb-0 text-center">You can add leads manually or via a CSV file, and they will be shown here.</p>
                            <p class="text-md text-secondary mb-0 text-center">If you are doing a search instead, no matching records were found.</p>
                            {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                          </div>
                        </div>
                      </td>
                        {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                        {{-- @if (is_null($user_csv_list->processing_started_at))
                          <span class="text-secondary text-xs font-weight-bold">--</span>
                        @else
                          <span class="text-secondary text-xs font-weight-bold">{{$user_csv_list->processing_started_at}}</span>
                        @endif --}}
                      {{-- <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          View
                        </a>
                      </td> --}}
                    </tr>
                    @else
                    @php
                      // $i=0;
                      // request()->fullurl() != null ? 
                      // url()->current() != null ? 
                      $page_numb = request()->input('page') != null ? request()->input('page') : 1;  
                      $i=$page_numb*14-13;
                    @endphp

                @foreach ($userLeads as $lead)

                    <tr>
                      <td class="ps-4">
                        <p class="text-xs font-weight-bold mb-0">{{$i}}</p>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            {{-- <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1"> --}}
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                          @if (is_null($lead->first_name))
                            <h6 class="mb-0 text-sm">--</h6>
                              @else
                            <h6 class="ms-2 mb-0 text-sm" id="first_name">{{$lead->first_name}}</h6>
                          @endif
                            {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                          </div>
                        </div>
                      </td>
                      <td>
                      @if (is_null($lead->last_name))
                        <h6 class="text-sm font-weight-bold mb-0">--</h6>
                          @else
                        <h6 class="text-sm font-weight-bold mb-0" id="last_name">{{$lead->last_name}}</h6>
                      @endif
                        {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                      </td>
                      <td class="align-middle text-center text-sm">
                      @if (is_null($lead->email))
                      <h6 class="text-sm font-weight-bold mb-0">--</h6>
                          @else
                      <h6 class="text-sm font-weight-bold mb-0" id="email">{{$lead->email}}</h6>
                      @endif
                        {{-- <span class="badge badge-sm bg-gradient-success">Online</span> --}}
                      </td>
                      {{-- <td class="align-middle text-center"> --}}
                      {{-- @if (is_null($lead->json_data))
                        <p class="text-xs font-weight-bold mb-0">--</P>
                          @else
                        @foreach (json_decode($lead->json_data) as $key => $other)
                        <p class="text-xs font-weight-bold mb-0">{{$key.": ".$other}}</P>
                        @endforeach
                      @endif --}}
                      {{-- <div class="info-btn" data-lead={{$lead->token}}>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                      </div>
                      </td> --}}
                      {{-- <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td> --}}
                      <td class="align-middle text-center">
                        <button class="info-btn utility-icon" data-lead={{$lead->token}}>
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </button>
                        <button class="edit utility-icon" data-lead-token="{{$lead->token}}">
                          <svg class="changes" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                        </button>
                        <button class="lead-delete-btn utility-icon" data-lead-token="{{$lead->token}}">
                          <svg class="demolish" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                        </button>
                      </td>
                    </tr>
                    @php
                    $i++
                  @endphp 
                    @endforeach
                    @endif
                    {{-- <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user2">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Alexa Liras</h6>
                            <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">11/01/19</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user3">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Laurent Perrier</h6>
                            <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Executive</p>
                        <p class="text-xs text-secondary mb-0">Projects</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">19/09/17</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3" alt="user4">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Michael Levi</h6>
                            <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programator</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-success">Online</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">24/12/08</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user5">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Richard Gran</h6>
                            <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                        <p class="text-xs text-secondary mb-0">Executive</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">04/10/21</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3" alt="user6">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Miriam Eric</h6>
                            <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Programtor</p>
                        <p class="text-xs text-secondary mb-0">Developer</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">14/09/20</span>
                      </td>
                      <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td>
                    </tr> --}}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        {{$userLeads->links()}}
        
      </div>

      <!-- <div id="modal">
        <div id="modal-form">
            <div class="modal-header">
                <h2>Lead Details</h2>
            </div>
            <div class="modal-body">

            </div>
            <div class="close-icon">X</div>
        </div>
    </div> -->
@endsection