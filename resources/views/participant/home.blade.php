@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success')}}
                </div>
            @endif
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message')}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Workshops</div>
                     <?php $allworkshops = auth()->user()->pWorkshops ?>
                    <div class="card-body">
                        @if($allworkshops->count() == 0) 
                            <h3 class="text text-center"> No Worskhops Yet </h3>
                            @else
                            <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">workshop title</th>
                                            <th>workshop date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; ?>
                                        @foreach ($allworkshops as $wp)
                                            <tr>
                                                <th> {{ $i  }} </th>
                                                <td>
                                                    {{ $wp->title }}
                                                </td>
                                                <td>
                                                    {{ $wp->created_at }}
                                                </td>
                                                <td class="white-space: nowrap">
                                                    @if($wp->stage==3)
                                                        <a href="{{route('group',$wp->id)}}" class="btn btn-primary">View Project</a>
                                                    @else
                                                        <a href="{{route('group',$wp->id)}}" class="btn btn-warning text-white">Continue Where You Left</a>
                                                    @endif
                                                </td> 
                                            </tr>
                                        <?php $i++; ?>
                                        @endforeach

                                    </tbody>
                            </table>
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
