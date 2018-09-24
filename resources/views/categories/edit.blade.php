@extends('layouts.dashboard')
@section('content')


<div class="justify-content-center align-items-center container col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Edit Category</strong>
        </div>
        <div class="card-body">
            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'PUT']) !!}
                @include('categories.form')
            {!! Form::submit('Update Category', ['class' => 'btn btn-success btn-lg']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>


@endsection

