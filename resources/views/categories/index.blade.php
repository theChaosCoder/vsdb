@extends('layouts.dashboard')
@section('content')

@include('partials.error')
<div class="col-md-12">
    <a href="/dashboard/categories/create" class="btn btn-success mb-3 btn-lg">Add new Category</a>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Categories</strong>
        </div>
        <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/dashboard/categories/{{ $category->id }}/edit" class="btn btn-secondary btn-sm" role="button">edit</a>
                                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method'  => 'DELETE']) !!}
                                {!! Form::submit('delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
