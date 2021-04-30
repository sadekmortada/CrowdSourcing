@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 my-3">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                <div class="card my-3">
                            <div class="card-body">
                                <h4 class="card-title">Workshop Key :</h4>
                                <input disabled = "disabled" type="text" id="key" class="form-control" value=" {{$workshop->workshop_key}} " >
                                <div class="mt-3"> 
                                    <button id="copybtn" onclick="copy()" type="button" class="btn btn-primary" >Copy</button>
                                </div>
                            </div>
                </div>
                <div class="card my-5">
                    <div class="card-header"> <h4> Participants joined until now </h4></div>
                    <div class="card-body">
                        @if($users->count()==0)
                        <h3 class="text text-center">No Participants Yet</h3>
                        @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th> 
                                    <th scope="col">Name</th> 
                                    <th scope="col">Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- TRY TO MAKE COL ACTIONS AT THE END OF THE TABLE --}}
                                <?php $i = 1 ?>
                                @foreach ( $users as $user)
                                    <tr> 
                                        <th> {{ $i  }} </th>
                                        {{-- in order to keep buttons in the same line use white-space: nowrap --}}
                                        <td>  {{ $user->name }}  </td>
                                        <td>
                                            {{ $user->email }}      
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            </tbody>
                    </table>
                        @endif
                    </div>
                </div>
                    @if($workshop->locked == 0)
                    <form method="post" action="{{route('joindoor',$workshop->id)}}" >
                        @method('put')
                        @csrf
                        <button  type="submit" class="btn btn-danger  my-2 float-left" >&nbsp;Deny Participating</button>
                    </form> 
                        @else 
                        <form method="post" action="{{route('joindoor',$workshop->id)}}" >
                            @method('put')
                            @csrf
                        <button  type="submit" class="btn btn-success  my-2 float-left" >Allow Participating</button>
                    </form> 
                        <form method=get action="{{ route('takecards',$workshop->id) }}">
                            <button  type="submit" class="btn btn-success  my-2 float-right">Start Filling Cards</button>
                        </form>
                    @endif    
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script> 
function copy() {
    btn = document.getElementById('copybtn')
    key = document.getElementById('key');
    keyv = key.value;
    key.disabled = false;
    key.select();
    document.execCommand('copy');
    key.disabled = true;

    
    }
</script>
@endsection
