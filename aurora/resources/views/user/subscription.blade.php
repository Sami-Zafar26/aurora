@extends('layouts.user_type.auth')
@section('content')
@push('title')
  <title>Aurora | Subscriptions</title>
@endpush


    <div class="row">
        @foreach ($subscriptions as $subscription)
        @if ($subscription->current_plan == 1)
        <div class="col-md-4 col-sm-12">
            <div class="pricing-card basic">
                <div class="head">Current Plan</div>
                <h3 id="package_name">{{$subscription->package_name}}</h3>
                <h1 id="package_price">${{$subscription->package_price}}</h1>
                <ul>
                    <li>{{$subscription->compaign_allowed}} Compaign Allowed</li>
                    <li>{{$subscription->lead_allowed}} Lead Allowed</li>
                    <li>For {{$subscription->package_duration}} Months</li>
                </ul>
                <button type="button" class="subscribe" data-token="{{$subscription->package_token}}">Subscribe</button><br>
            </div>
        </div>
        @else
        <div class="col-md-4 col-sm-12">
            <div class="pricing-card basic">
                <h3 id="package_name">{{$subscription->package_name}}</h3>
                <h1 id="package_price">${{$subscription->package_price}}</h1>
                <ul>
                    <li>{{$subscription->compaign_allowed}} Compaign Allowed</li>
                    <li>{{$subscription->lead_allowed}} Lead Allowed</li>
                    <li>For {{$subscription->package_duration}} Months</li>
                </ul>
                <button type="button" class="subscribe" data-token="{{$subscription->package_token}}">Subscribe</button><br>
            </div>
        </div>
        @endif
        
        @endforeach
    </div>
@endsection