@extends('layouts.user_type.auth')
@push('title')
  <title>Aurora | Users</title>
@endpush
@section('content')

<div class="card card-height mb-4 mx-4">
    <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">All Users</h5>
            </div>
            <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; New User</a>
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
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            First Name
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Last Name
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Email
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Role
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i=0;
                @endphp
                @foreach ($users_info as $user_info )
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td class="ps-4">
                            <p class="text-xs font-weight-bold mb-0">{{$i}}</p>
                        </td>
                        <td class="text-center">
                            <a href="#" class="text-xs font-weight-bold mb-0">{{$user_info->first_name}}</a>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{$user_info->last_name}}</p>
                        </td>
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0">{{$user_info->email}}</p>
                        </td>
                        @if ($user_info->is_admin == 1)
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0"><span class="badge bg-gradient-primary">Admin</span></p>
                        </td>
                            @else
                        <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0"><span class="badge bg-gradient-warning">User</span></p>
                        </td>
                        @endif
                        <td class="text-center text-sm">
                        @if ($user_info->banned == 0)
                            <button type="button" class="bann btn btn-sm bg-gradient-danger" data-user-token="{{$user_info->token}}">Bann</button>
                            @else
                            <button type="button" class="unbann btn btn-sm bg-gradient-success" data-user-token="{{$user_info->token}}">UnBann</button>
                        @endif
                            {{-- <a href="#" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                <i class="fas fa-user-edit text-secondary" aria-hidden="true"></i>
                            </a>
                            <span>
                                <i class="cursor-pointer fas fa-trash text-secondary" aria-hidden="true"></i>
                            </span> --}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{$users_info->links()}}
</div>

@push('admin-ajax')
    <script src="{{asset('assets/js/admin-ajax.js')}}"></script>
@endpush
@endsection