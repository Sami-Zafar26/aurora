@extends('layouts.user_type.auth')

@section('content')
@push('title')
  <title>Aurora | Campaign Template</title>
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
  
  <div class="modal fade" id="campaign-deletemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete List</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <p class="font-weight-bold mb-0">Are you sure you want to delete this list?</p>
          <input type="hidden" id="campaign-token" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary cancel-delete-btn" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger delete">Delete</button>
        </div>
    </div>
  </div>
</div>

<div class="card card-height mb-4 mx-4">
    <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">All Templates</h5>
            </div>
            <a href="{{route('create-template')}}" class="btn bg-gradient-primary btn-sm mb-0" type="button">Create Template</a>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            ID
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            Template Name
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Template Subject
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($campaign_templates->isEmpty())
                    <tr>
                        <td colspan="5" class="ps-4 text-center">
                            <p class="text-md font-weight-bold mb-0 mt-2">You have not created the template yet!</p>
                        </td>
                    </tr>   
                    @else
                    @php
                        $i=0;
                    @endphp
                    @foreach ($campaign_templates as $campaign_template )
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{$i}}</p>
                        </td>
                        <td>
                            <div>
                                {{-- <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3"> --}}
                                <p class="text-xs font-weight-bold mb-0">{{$campaign_template->campaign_template_name}}</p>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{$campaign_template->campaign_template_subject}}</p>
                        </td>
                        <td class="text-center">
                            <button type="button" class="template-view utility-icon" data-campaign-template-token="{{$campaign_template->token}}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                            </button>
                            {{-- <p class="text-xs font-weight-bold mb-0">Admin</p> --}}
                            <button type="button" class="campaign-template-edit utility-icon" data-campaign-template-token="{{$campaign_template->token}}" >
                                <svg class="changes" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                            </button>
                            <button type="button" class="campaign-template-delete utility-icon" data-campaign-template-token="{{$campaign_template->token}}" >
                                <svg class="demolish" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection