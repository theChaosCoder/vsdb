@extends('layouts.dashboard')
@section('content')


<div class="container">
    <h2>Edit Plugin</h2><br />
    {!! Form::model($plugin, ['route' => ['plugins.update', $plugin->id], 'method' => 'PUT']) !!}
        @include('plugins.form')
    {!! Form::submit('Update Plugin', ['class' => 'btn btn-success btn-lg']) !!}
    {!! Form::close() !!}
</div>

<div style="margin-top: 20px;">
    @if(!empty($plugin->functions))
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Plugin Functions</strong>
                </div>
                <div class="card-body">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plugin->functions as $pfunction)
                            <tr>
                                <td>{{ $pfunction->id }}</td>
                                <td>{{ $pfunction->name }}</td>
                                <td>{{ $pfunction->plugins['name'] }}</td>
                                <td><small>{{ $pfunction->categories['name'] }}</small></td>
                                <td><small>{{ $pfunction->description }}</small></td>
                                <td>{{ $pfunction->bitdepth }}</td>
                                <td>{{ $pfunction->colorspace }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/dashboard/pluginfunctions/{{ $pfunction->id }}/edit" class="btn btn-secondary btn-sm" role="button">edit</a>
                                        {!! Form::open(['route' => ['pluginfunctions.destroy', $pfunction->id, "pluginid" => $plugin->id, "editplugin"], 'method'  => 'DELETE']) !!}
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
    @endif
</div>

@endsection

