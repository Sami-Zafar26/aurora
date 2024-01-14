@extends('layouts.user_type.auth')
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
          
        </div>
        <div class="col-md-12 px-3">
          <div class="reference"></div>
          <button type="button" id="additional-attribute-btn" class="btn btn-sm btn-info my-2">Additional Attribute</button>
        </div>
        <div class="modal-footer">
          <button type="button" id="close-edit-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary update">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

        <div class="row">
        <div class="col-12">
          <div class="card card-height mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6>List Leads </h6>
              <div class="search-box">
                <form action="{{route('list-leads',['id'=>$id])}}" method="get" class="search-form">
                  @if (isset($search))
                  <input type="search" class="form-control" name="search_query" id="" placeholder="Search..." value="{{$search}}">
                  @else
                  <input type="search" class="form-control" name="search_query" id="" placeholder="Search...">
                  @endif
                  <input type="submit" class="btn btn-info m-0" value="Search">
                </form>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">First Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Name</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Info</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if ($listLeads->isEmpty())
                    <tr>
                      <td colspan="9">
                        <div class="d-flex px-2 py-3 justify-content-center">
                          <div class="file-icon mx-2">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><a href="#" class="text-muted">You not have uploaded list Yet!</a></h6>
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
                  @foreach ($listLeads as $listLead)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div>
                            {{-- <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1"> --}}
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                          @if (is_null($listLead->first_name))
                            <h6 class="mb-0 text-sm">--</h6>
                              @else
                            <h6 class="ms-2 mb-0 text-sm">{{$listLead->first_name}}</h6>
                          @endif
                            {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                          </div>
                        </div>
                      </td>
                      <td>
                          @if (is_null($listLead->last_name))
                            <h6 class="mb-0 text-sm">--</h6>
                              @else
                            <h6 class="mb-0 text-sm">{{$listLead->last_name}}</h6>
                          @endif
                        {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                      </td>
                      <td class="align-middle text-center text-sm">
                          @if (is_null($listLead->email))
                            <h6 class="mb-0 text-sm">--</h6>
                              @else
                            <h6 class="mb-0 text-sm">{{$listLead->email}}</h6>
                          @endif
                        {{-- <span class="badge badge-sm bg-gradient-success">Online</span> --}}
                      </td>
                      <td class="align-middle text-center">
                        <div class="info-btn" data-lead={{$listLead->token}}>
                          <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                        </div>
                        {{-- <span class="text-secondary text-xs font-weight-bold">23/04/18</span> --}}
                      </td>
                      {{-- <td class="align-middle">
                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                      </td> --}}
                      <td class="align-middle text-center">
                        <button class="edit btn btn-sm bg-gradient-info" data-lead-token="{{$listLead->token}}">Edit</button>
                        <button class="delete btn btn-sm bg-gradient-danger" data-lead-token="{{$listLead->token}}">Delete</button>
                      </td>
                    </tr>
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
        {{$listLeads->links()}}
      </div>
@endsection