@extends('layouts.app')

@section('content')
@if (auth()->user()->can_vote)
<div class="alert my-5 alert-danger">
    <h2>Please wait until all participants finish voting !</h2>
</div>
@else
<form method=post action="{{route('shuffilecards',$workshop->id)}}">
    @csrf
    @method('put')
    <input type=submit class="btn btn-success my-5" value="Shuffile & Distribute">
</form>
@endif
@endsection