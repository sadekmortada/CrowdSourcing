@extends('layouts.app')
@section('content')
<?php $roles = ['Admin' , 'Monitor' , 'Participant'] ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Users</div>

                        <div class="card-body">
                             @if($users->count() == 0)
                                <h3 class="text text-center"> No Users Yet </h3>
                                @else
                                <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th> Role </th> 
                                                <th>Name</th>
                                                <th scope="col">Email</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($users as $user)
                                                <tr> 
                                                    <th> {{ $i  }} </th>
                                                    <td>   {{ $roles[$user->role] }}</td>
                                                    <td>{{$user->name}}</td>
                        
                                                    <td> {{$user->email }} </td>
                             
                                                    <td style='white-space: nowrap'>
                                                        @if ($user->role != 0)
                                                            <form method="post" action="{{ route('updateuser', $user->id)  }}" >
                                                                @method('PUT')
                                                                @csrf
                                                                @if($user->confirmed == '0')
                                                                    <button name="confirm" type="submit" class="btn btn-success btn-sm" >Confirm</button>
                                                                    @else 
                                                                    <button name="ban" type="submit" class="btn btn-danger btn-sm" >&nbsp; &nbsp;Ban &nbsp; &nbsp;</button>
                                                                @endif
                                                                <button name="remove" type="submit" class="btn btn-danger btn-sm" >Remove</button>
                                                            </form>     
                                                        @endif
                                                            
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                            @endforeach

                                        </tbody>
                                </table>
                            @endif
                        </div>
                </div>
                <form method="post" action="{{ route('autoconfirm')  }}" >
                    @method('PUT')
                    @csrf
                    @if(auth()->user()->auto_confirm == '0')
                        <button  type="submit" class="btn btn-success  my-2 float-right" >Allow Auto Confirm</button>
                        @else 
                        <button  type="submit" class="btn btn-danger  my-2 float-right" >Disable Auto Confirm</button>
                    @endif
                </form>     
                
            </div>
        </div>
    </div>
@endsection
