@extends('layouts.dashboard')
@section('content')


<div class="container">
    <h2>Add Plugin</h2><br />
    {!! Form::open(['route' => 'plugins.store']) !!}
    @include('plugins.form')
    {!! Form::submit('Add Plugin', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}

</div>

@endsection
