@extends('layouts.app')

@section('content')
@if (!($workshop->voted==$workshop->participated))
<div class="alert my-5 alert-danger">
    <h2>Please wait until all participants finish submitting !</h2>
</div>
@endif
@endsection