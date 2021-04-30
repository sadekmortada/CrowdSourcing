@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header"> Voting Results </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th> 
                                    <th scope="col">Card Title</th>
                                    <th scope="col">Total Score</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @csrf
                                <?php $i = 1 ?>
                                @foreach ( $cards as $card)
                                    <tr> 
                                        <th> {{ $i  }} </th>
                                        <td>  {{ $card->title }}  </td>
                                        <td>{{ $card->score }}  </td>
                                        @if ($card->takenAsProject)
                                            <td> <a href="{{route('chooseproject',[$workshop->id,$card->id])}}" class="btn btn-info"> <font color='white'> Edit </font></a> </td>
                                        @else
                                        <td>  <a href="{{route('chooseproject',[$workshop->id,$card->id])}}" class="btn btn-secondary">  Take As Project </a></td>
                                        @endif
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
            @if (isset($project))
            <div class="col-md-6">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                @if($participants->count()==0 && isset($members) && $members->count()==0)
                    <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">	No more free participants </div>
                        <div class="card-body">
                        </div>
                    </div>    
                @else
                <div class="card">
                    <div class="card-header"> Choose group members for <font color='red'> <b>"{{$project->title}}"</b> </font> among the available participants</div>
                    <div class="card-body">
                        <form method="post" action="{{route('addmembers',[$workshop->id,$project->id])}}">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th> 
                                    <th scope="col"> User  </th>
                                    <th scope="col"></th>
                                    <th></th>
                                </tr>
                                
                            </thead>
                            <tbody>
                               
                                @csrf
                                <?php $i = 1 ?>
                                @if(isset($members))
                                @foreach ( $members as $member)
                                <tr> 
                                    <th> {{ $i  }} </th>
                                    <td>  {{ $member->name }}  </td>
                                    <td>  <input type="checkbox" name="members[]" value="{{$member->id}}" checked>  </td>
                                </tr>
                                <?php $i++ ?>
                            @endforeach
                            @endif
                                @foreach ( $participants as $participant)
                                    <tr> 
                                        <th> {{ $i  }} </th>
                                        <td>  {{ $participant->name }}  </td>
                                        <td>  <input type="checkbox" name="members[]" value="{{$participant->id}}">  </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                               
                            </tbody>
                    </table>
                    <input type="submit" class="btn btn-success" value="Apply"  />
                </form>
                </div>
                </div>
                @endif 
                @else 
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Choose card to view available participants</div>
                        <div class="card-body">
                        </div>
                    </div> 
            @endif
            </div>
        </div>
    </div>
@endsection
