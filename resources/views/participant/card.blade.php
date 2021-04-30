@extends('layouts.app')
@section('content')
@if (!$monitor->can_vote)
<div class="alert my-5 alert-danger">
    <h2>Please wait until recieving card !</h2>
</div>
@else
@if(!auth()->user()->can_vote)
<div class="alert my-5 alert-danger">
    <h2>Please wait until others finish voting !</h2>
</div>
@else
<div class="card" style="margin-top:3%;margin-left:15%;margin-right:15%">
    <div class="card-header">Card Details</div>
        <div class="card-body">
            <div class="form-group">
            <input name="title" type="text" class="form-control" value="{{$card->title}}" readonly>
            </div>
            <div class="form-group">                    
                <textarea cols="8" rows="4" name="body"  class="form-control" readonly>{{$card->body}}</textarea>
            </div>
        </div>
    </div>
<div class="card" style="margin:3%;margin-left:15%;margin-right:15%">
    <div class="card-header">Rate This Suggestion</div>
        <div class="card-body">
        <form method="post" action="{{route('votecard',$workshop->id)}}">
                @method('put')
                @csrf
                <div class="form-group">
                    <select name="score" class="form-control"><option value=1>1</option><option value=2>2</option>
                                <option value=3>3</option><option value=4>4</option><option value=5>5</option></select>
                </div>
                <button type="submit"  class="btn btn-primary btn-md float-right" >Submit Card</button>
            </form>
        </div>
    </div>
@endif
@endif
@endsection
