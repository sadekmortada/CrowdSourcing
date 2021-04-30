@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if($card)
                {{-- this participant has project in this workshop, so display project details and the members --}}
            <div class=card>
                <div class="card-header">Project Details</div>
                <div class="card-body">
                <div class="form-group"><p class="float-left">Title:</p>
                <input name="title" type="text" class="form-control" value="{{$card->title}}" readonly>
                </div>
                <div class="form-group"><p class="float-left">Description:</p>                   
                <textarea cols="8" rows="4" name="body"  class="form-control" readonly>{{$card->body}}</textarea>
                </div>
                </div>
                </div>
            </div>
                <div class="card">
                    <div class="card-header"> Group Members </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"> # </th> 
                                    <th scope="col"> User </th>
                                    <th scope="col"> Email </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tr>
                                <th><font color="blue"> 1 </font></th>
                                <td><i><font color="blue"> You </font></i></td>
                                <td><font color="blue"> {{Auth::user()->email}} </font></td>
                            </tr>
                            <tbody>
                                @csrf
                                <?php $i = 2 ?>
                                @foreach ( $members as $member)
                                <tr> 
                                    <th> {{$i}} </th>
                                    <td>  {{$member->name}}  </td>
                                    <td> {{$member->email}} </td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                </div>
                @else
                {{-- else no project yet for this user in the workshop --}}
                <div class="alert alert-danger">
                    You don't have a project in this workshop yet
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
