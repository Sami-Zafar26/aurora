@extends('layouts.app')

@section('guest')
    @if(\Request::is('login/forgot-password')) 
        {{-- @include('layouts.navbars.guest.nav') --}}
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            @yield('content') 
        </div>
    @else
        {{-- <div class="container position-sticky z-index-sticky top-0"> --}}
            {{-- <div class="row"> --}}
                {{-- <div class="col-12"> --}}
                    {{-- @include('layouts.navbars.guest.nav') --}}
                {{-- </div> --}}
            {{-- </div> --}}
        {{-- </div> --}}
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            @yield('content')        
        </div>
        {{-- @include('layouts.footers.guest.footer') --}}
    @endif
@endsection