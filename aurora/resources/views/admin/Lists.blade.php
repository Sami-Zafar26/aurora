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


  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content content" id="form-transition">


          <div class="form-box upload-file">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Csv file</h1>
          <button type="button" class="btn-close text-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="uploadfile">
          @csrf
          <div class="modal-body">
              <div class="col-md-12">
                <p class="text-md mb-0">Please upload a CSV file, It must have email column.</p>
                <p class="text-md">Additional columns are allowed and will be processed accordingly.</p>
              </div>
              <div class="mb-3">
                <label for="formFile" class="form-label">Upload the Csv file</label>
                <input class="form-control" type="file" name="csv_file" id="formFile" required>
              </div>
              <div class="mb-3">
                <label for="list_name" class="form-label">Give name to your list</label>
                <input class="form-control" type="text" name="list_name" id="list_name" placeholder="list name...">
              </div>
              <div class="mb-3">
                <label for="list_description" class="form-label">Description about list (Optional)</label>
                <textarea name="list_description" id="list_description" class="form-control" cols="30" rows="4"
                  placeholder="Description here..."></textarea>
              </div>
              <div class="link-group">
                <button type="submit" class="btn btn-sm btn-primary m-0">Upload</button>
                <a href="#" class="upload-existed-link" >Upload in existed list?</a>
              </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>

        <div class="form-box upload-in-existed-file">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="text-md mb-0">If you want to add leads to an existing CSV file, you can do it here.</p>
            <form id="upload-csv-in-existed-list">
              @csrf
              <div class="mb-3">
                <label for="formFile" class="form-label">Upload the Csv file</label>
                <input class="form-control" type="file" name="file" id="File" required>
              </div>
              <div class="md-3">
                <label for="inputPassword" class="col-sm-4 form-label">Choose List</label>
                <select id="select-list-mandatory" name="list_token" class="form-select"
                  aria-label="Default select example">
                </select>
              </div>
              <div class="link-group mt-3">
                <button type="button" class="btn btn-sm btn-dark m-0" id="form-back">Back</button>
                <button type="submit" class="btn btn-sm btn-primary m-0">Save</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="reupload-list-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Csv file</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="reupload-list">
          @csrf
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-xs text-secondary mb-0">Please upload a CSV file, It must have email column.</p>
                </div>
              </div>
              <div class="mb-3">
                <input type="hidden" name="token" id="token">
                <label for="file" class="form-label">Upload the Csv file</label>
                <input class="form-control" type="file" name="csv_file" id="reupload-file" required>
              </div>
              <div class="mb-3">
                <label for="list_name" class="form-label">Give name to your list</label>
                <input class="form-control" type="text" name="list_name" id="listname" placeholder="list name...">
              </div>
              <div class="mb-3">
                <label for="list_description" class="form-label">Description about list (Optional)</label>
                <textarea name="list_description" id="listdescription" class="form-control" cols="30" rows="4"
                  placeholder="Description here..."></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="custom-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content manaul" id="manaully-form-transition" style="height: 470px; transition: 0.18s;">

        <div class="list-add">

        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Manually</h1>
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

    </div>


        <div class="single-lead-add">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
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
              <div class="reference">
  
              </div>
              <button type="button" id="additional-attribute-btn" class="btn btn-sm btn-info m-0">Additional
                Attribute</button>
              <br>
              <div class="link-group mt-3">
                <button type="button" class="btn btn-sm btn-dark m-0" id="manaul-form-back">Back</button>
                <button type="submit" id="upload-manual-btn" class="btn btn-primary btn-sm mb-0">Save</button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit List</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="list-update-form">
          <div class="modal-body" id="edit-list">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary update" id="list-update-btn">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- <div class="row d-flex justify-content-end">
    <div class="add-list-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      <svg xmlns="http://www.w3.org/2000/svg" height="1em"
        viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
        <path
          d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
      </svg>
    </div>
  </div> --}}

  <!-- table -->
  <div class="row my-4">
    <div class="col-12">
      <div class="card card-height mb-4">
        <div class="card-header d-flex justify-content-between align-items-center pb-2">
          <h6 class="m-0">Your Lists</h6>
          <div class="add-btn-group">
            <button class="add-button" data-bs-toggle="modal" data-bs-target="#custom-add">Add Manually</button>
            <div class="add-list-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                <path
                  d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
              </svg>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sr.#</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">List Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status
                  </th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Processing
                    Started At</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Processing
                    Completed At</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action
                  </th>
                </tr>
              </thead>
              <tbody id="user-list">
                @if ($user_csv_lists->isEmpty())
                <tr>
                  <td colspan="6">
                    <div class="d-flex px-2 py-3 justify-content-center">
                      <div class="file-icon mx-2">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm"><a href="#" class="text-muted">You have not uploaded the list yet!</a>
                        </h6>
                      </div>
                    </div>
                  </td>
                </tr>
                @else
                @foreach ($user_csv_lists as $user_csv_list)
                @if ($user_csv_list->status=="error")
                <tr>
                  <td class="ps-4">
                    <p class="text-xs font-weight-bold mb-0">1</p>
                  </td>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="file-icon mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                          <path
                            d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        {{-- @if (is_null($user_csv_list->list_name))
                        <h6 class="mb-0 text-sm"><a href="{{route('list-leads',['id'=>$user_csv_list->token])}}"
                            id="list_name">{{$user_csv_list->file_name}}</a></h6> --}}
                        {{-- @else --}}
                        <h6 class="mb-0 text-sm"><a href="{{route('list-leads',['id'=>$user_csv_list->token])}}"
                            id="list_name">{{$user_csv_list->list_name}}</a></h6>
                        {{-- @endif --}}
                      </div>
                    </div>
                  </td>
                  <td>
                    @if (is_null($user_csv_list->list_description))
                    <p class="text-xs ms-4 font-weight-bold mb-0" id="list_description">--</p>
                    @else
                    <p class="text-xs font-weight-bold mb-0" id="list_description">{{$user_csv_list->list_description}}
                    </p>
                    @endif
                  </td>
                  <td class="align-middle text-center text-sm">
                    @if ($user_csv_list->status=="pending")
                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                    @elseif ($user_csv_list->status=="processing")
                    <span class="badge badge-sm bg-gradient-info">Processing</span>
                    @elseif ($user_csv_list->status=="completed")
                    <span class="badge badge-sm bg-gradient-success">Completed</span>
                    @elseif ($user_csv_list->status=="manual")
                    <span class="badge badge-sm bg-gradient-secondary">Manual</span>
                    @else
                    <span class="badge badge-sm bg-gradient-danger">Error</span>
                    @endif
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{$user_csv_list->error_message}}</span>
                  </td>
                  <td class="align-middle text-center">
                    <div class="reupload-icon">
                      <span id="{{$user_csv_list->token}}" class="reupload-list text-muted form-text"><svg
                          xmlns="http://www.w3.org/2000/svg" height="1em"
                          viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                          <path
                            d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z" />
                        </svg> Reupload List</span>
                    </div>
                  </td>
                  <td classs="align-middle text-center">
                    <button class="list-delete btn btn-sm bg-gradient-danger"
                      data-list-token="{{$user_csv_list->token}}">Delete</button>
                  </td>
                </tr>
                @push('reupload-list')
                <script src="{{asset('assets/js/script.js')}}"></script>
                @endpush
                @else
                <tr>
                  <td class="ps-4">
                    <p class="text-xs font-weight-bold mb-0">1</p>
                  </td>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="file-icon mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                          <path
                            d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128z" />
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        {{-- @if (is_null($user_csv_list->list_name)) --}}
                        {{-- <h6 class="mb-0 text-sm"><a
                            href="{{route('list-leads/',['id'=>$user_csv_list->token])}}">{{$user_csv_list->file_name}}</a>
                        </h6> --}}
                        {{-- @else --}}
                        <h6 class="mb-0 text-sm"><a
                            href="{{route('list-leads',['id'=>$user_csv_list->token])}}">{{$user_csv_list->list_name}}</a>
                        </h6>
                        {{-- @endif --}}
                      </div>
                    </div>
                  </td>
                  <td>
                    @if (is_null($user_csv_list->list_description))
                    <p class="text-xs ms-4 font-weight-bold mb-0">--</p>
                    @else
                    <p class="text-xs font-weight-bold mb-0">{{$user_csv_list->list_description}}</p>
                    @endif
                  </td>
                  <td class="align-middle text-center text-sm">
                    @if ($user_csv_list->status=="pending")
                    <span class="badge badge-sm bg-gradient-warning">Pending</span>
                    @elseif ($user_csv_list->status=="processing")
                    <span class="badge badge-sm bg-gradient-info">Processing</span>
                    @elseif ($user_csv_list->status=="completed")
                    <span class="badge badge-sm bg-gradient-success">Completed</span>
                    @elseif ($user_csv_list->status=="manual")
                    <span class="badge badge-sm bg-gradient-secondary">Manual</span>
                    @else
                    <span class="badge badge-sm bg-gradient-danger">Error</span>
                    @endif
                  </td>
                  <td class="align-middle text-center">
                    @if (is_null($user_csv_list->processing_started_at))
                    <span class="text-secondary text-xs font-weight-bold">--</span>
                    @else
                    <span
                      class="text-secondary text-xs font-weight-bold">{{$user_csv_list->processing_started_at}}</span>
                    @endif
                  </td>
                  <td class="align-middle text-center">
                    @if (is_null($user_csv_list->processing_completed_at))
                    <span class="text-secondary text-xs font-weight-bold">--</span>
                    @else
                    <span
                      class="text-secondary text-xs font-weight-bold">{{$user_csv_list->processing_completed_at}}</span>
                    @endif
                  </td>
                  <td classs="align-middle text-center">
                    <button class="list-edit btn btn-sm bg-gradient-info"
                      data-list-token="{{$user_csv_list->token}}">Edit</button>
                    <button class="list-delete btn btn-sm bg-gradient-danger"
                      data-list-token="{{$user_csv_list->token}}">Delete</button>
                  </td>
                </tr>
                @endif
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    {{$user_csv_lists->links()}}
  </div>
  {{--
</div> --}}

@endsection