@extends('layouts.dashboard')
@section('content')


<div class="container">
    <h2>Add Plugin Function</h2><br />
    {!! Form::open(['route' => 'pluginfunctions.store']) !!}
    @include('pluginfunctions.form')
    {!! Form::submit('Add Plugin Function', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}

</div>

@endsection
