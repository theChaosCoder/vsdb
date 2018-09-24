@extends('layouts.dashboard')
@section('content')


<div class="container">
    <h2>Edit Plugin Function</h2><br />
    {!! Form::model($pluginfunction, ['route' => ['pluginfunctions.update', $pluginfunction->id], 'method' => 'PUT']) !!}
        @include('pluginfunctions.form')
    {!! Form::submit('Update Plugin Function', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}

</div>

</div>

@endsection

