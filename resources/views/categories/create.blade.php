@extends('layouts.dashboard')
@section('content')


<div class="container">
    <h2>Add Category</h2><br />
    {!! Form::open(['route' => 'categories.store']) !!}
    @include('categories.form')
    {!! Form::submit('Add Category', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}

</div>

@endsection
