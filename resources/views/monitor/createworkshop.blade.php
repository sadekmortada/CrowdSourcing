@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                @if(session()->has('errors'))
                        <div class="alert alert-danger">
                            {{ session()->get('errors')->first() }}
                        </div>
                @endif
                <div class="card">
                <div class="card-header">Create A New Workshop</div>
                    <div class="card-body">
                    <form method="post" action="{{route('storeworkshop')}}">
                            @csrf
                            <div class="form-group">
                                <input name="title" placeholder="Title" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <textarea cols="8" rows="8" name="body" placeholder="Problem"  class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <input name="participants" placeholder="Participants Number" type="text" class="form-control" required>
                            </div>
                            <button type="submit"  class="btn btn-primary btn-md float-right" >Create Workshop</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


