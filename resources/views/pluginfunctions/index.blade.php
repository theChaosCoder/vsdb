@extends('layouts.dashboard')
@section('content')

@include('partials.error')
<div class="col-md-12">
    <a href="/dashboard/pluginfunctions/create" class="btn btn-success mb-3 btn-lg">Add new Function</a>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Plugin Functions</strong>
        </div>
        <div class="card-body">
            <p>Currently category and gpu are only relevant for Script-Collections. They can be set in <a href="/dashboard/plugins">Plugins</a></p>
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Plugin</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Bit depth</th>
                        <th>Color space</th>
                        <th>GPU support</th>
                        <th>Action</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pluginfunctions as $pfunction)
                    <tr>
                        <td>{{ $pfunction->id }}</td>
                        <td>{{ $pfunction->name }}</td>
                        <td>{{ $pfunction->plugins['name'] }}</td>
                        <td><small>{{ $pfunction->categories['name'] }}</small></td>
                        <td><small>{{ $pfunction->description }}</small></td>
                        <td>{{ $pfunction->bitdepth }}</td>
                        <td>{{ $pfunction->colorspace }}</td>
                        <td>{{ $pfunction->gpusupport }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/dashboard/pluginfunctions/{{ $pfunction->id }}/edit" class="btn btn-secondary btn-sm" role="button">edit</a>
                                {!! Form::open(['route' => ['pluginfunctions.destroy', $pfunction->id], 'method'  => 'DELETE']) !!}
                                {!! Form::submit('delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                        <td><small>{{ $pfunction->updated_at }}</small></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
