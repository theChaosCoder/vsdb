@extends('layouts.dashboard')
@section('content')


@include('partials.error')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Plugins that are not available via VSRepo</strong>
        </div>
        <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Namespace</th>
                        <th>Identifier</th>
                        <th>Category</th>
                        <th class="text-center">type</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plugins as $plugin)
                    <tr>
                        <td>{{ $plugin->id }}</td>
                        <td>{{ $plugin->name }}</td>
                        <td>{{ $plugin->namespace }}</td>
                        <td>{{ $plugin->identifier }}</td>
                        <td><small>{{ $plugin->categories['name'] }}</small></td>
                        <td class="text-center">
                            @if ($plugin->type == "PyScript")
                                <i class="far fa-file-alt" title="{{ $plugin->type }}"></i>
                            @else
                                <i class="fas fa-file-powerpoint" title="{{ $plugin->type }}"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="/dashboard/vsrepo/{{ $plugin->id }}/generate" target="_blank" class="btn btn-secondary btn-sm" role="button">generate package</a>
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
