@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                @if(session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                @endif
                <div class="card">
                <div class="card-header">Join A Workshop</div>
                    <div class="card-body">
                    <form method="post" action="{{route('applytoworkshop')}}">
                            @csrf
                            <div class="form-group">
                                <input name="key" placeholder="Workshop Key" type="text" class="form-control">
                            </div>
                            <button type="submit"  class="btn btn-primary btn-md float-right" >Join</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


