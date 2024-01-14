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
  

    <div class="row">
        <div class="col-md-12">
            <div class="bg-white p-3" style="border-radius:1rem;">
              <div class="card mt-3 mb-2 p-3 bg-gradient-light">
    <p class="mb-0 text-xs">You can utilize placeholders like &#123;&#123;first_name&#125;&#125; and &#123;&#123;last_name&#125;&#125; within your email templates. Additionally, for any additional information you provide about your contact in the 'attribute name' field, simply use the corresponding attribute names. For example, if you've entered a 'designation' attribute, use &#123;&#123;designation&#125;&#125; in your template.</p>
  </div>
            @isset($edit_template)
            @push('title')
              <title>Aurora | Edit Template</title>
            @endpush
            <form id="update-template-form">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="">Create Template</h4>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="">Template Name:</label>
                        <input type="text" class="form-control" name="campaign_template_name" id="campaign_template_name" value="{{$edit_template->campaign_template_name}}" placeholder="Template Name...">
                    </div>
                    <div class="col-md-6">
                        <label for="">Campaign Subject:</label>
                        <input type="hidden" name="token" id="token" value="{{$edit_template->token}}">
                        <input type="text" class="form-control" name="campaign_template_subject" id="campaign_template_subject" value="{{$edit_template->campaign_template_subject}}" placeholder="Campaign Subject...">
                    </div>
                </div>
                <label for="">Campaign Body:</label>
                <textarea name="campaign_template_body" id="default" cols="30" rows="10">{{$edit_template->campaign_template_body}}</textarea>
                <input type="submit" class="btn btn-sm btn-success mt-3" value="Update">
            </form>         
            @else
            @push('title')
              <title>Aurora | Create Template</title>
            @endpush
            <form id="create-template-form">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="">Create Template</h4>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="">Template Name:</label>
                        <input type="text" class="form-control" name="campaign_template_name" id="campaign_template_name" placeholder="Template Name...">
                    </div>
                    <div class="col-md-6">
                        <label for="">Campaign Subject:</label>
                        <input type="text" class="form-control" name="campaign_template_subject" id="campaign_template_subject" placeholder="Campaign Subject...">
                    </div>
                </div>
                <label for="">Campaign Body:</label>
                <textarea name="campaign_template_body" id="default" cols="30" rows="10"></textarea>
                <input type="submit" class="btn btn-sm btn-success mt-3" value="Save">
            </form>
            @endisset
            </div>
        </div>
    </div>

    @push('tinymce')
        <script src="{{asset('assets/tinymce/tinymce.min.js')}}"></script>
        <script src="{{asset('assets/js/tinymce.js')}}"></script>
    @endpush
@endsection