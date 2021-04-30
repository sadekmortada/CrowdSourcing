@extends('layouts.app')
@section('content')
<div class="card" style="margin-top:3%;margin-left:15%;margin-right:15%">
    <div class="card-header">Workshop Details</div>
        <div class="card-body">
            <div class="form-group"><p class="float-left">Title:</p>
            <input name="title" type="text" class="form-control" value="{{$workshop->title}}" readonly>
            </div>
            <div class="form-group"><p class="float-left">Description:</p>                   
                <textarea cols="8" rows="4" name="body"  class="form-control" readonly>{{$workshop->body}}</textarea>
            </div>
        </div>
    </div>
<?php 
use App\User;
$monitor = User::find($workshop->user_id); ?>
@if (!Auth::user()->can_submit || !$monitor->can_submit)
<div class="alert my-5 alert-danger">
    @if($monitor->can_submit)
    <h2> you have already submitted your card !</h2>
    @else 
    <h2> Please wait the workshop to start</h2>
    @endif
</div>
@else
<div class="card my-4" style="margin-left:15%;margin-right:15%">
    <div class="card-header"> <h4> Submit Your Card </h4> </div>
        <div class="card-body">
        <form method="post" action="{{route('storecard',$workshop->id)}}">
                @csrf
                <div class="form-group">
                    <input name="title" placeholder="Title" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <textarea cols="8" rows="4" name="body" placeholder="Solution Idea"  class="form-control" required></textarea>
                </div>
                <button type="submit"  class="btn btn-primary btn-md float-right" >Submit Card</button>
            </form>
        </div>
    </div>
@endif
@endsection