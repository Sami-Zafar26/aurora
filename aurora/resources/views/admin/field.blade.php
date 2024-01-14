@extends('layouts.user_type.auth')

@section('content')

 <form action="multifield" method="post">
    @csrf
    <input type="text" name="name">
    <input type="email" name="email">
    <input type="number" name="phone">
    <div class="blade">
        
    </div>
    <button type="button" id="add">Add</button>
    <button type="submit">Send</button>
 </form>

@endsection