@extends('layouts.user_type.auth')
@section('content')
@push('title')
<title>Aurora | Template View</title>
@endpush
    <div class="row">
        <div class="col-md-12">
            <div class="card-height template-view-background bg-white p-3 custom-rounded">
                <p class="text-md font-weight-bold">Subject Name: {{$campaign_templateRR->campaign_template_subject}}</p>
                <hr>

                {!!$campaign_templateRR->campaign_template_body!!}
            </div>
        </div>
    </div>
@endsection