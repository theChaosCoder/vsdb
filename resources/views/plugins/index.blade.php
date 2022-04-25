@extends('layouts.dashboard')
@section('content')


@include('partials.error')
<div class="col-md-12">
    <a href="/dashboard/plugins/create" class="btn btn-success mb-3 btn-lg">Add new Plugin</a>
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Plugins</strong>
        </div>
        <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Namespace</th>
                        <th>Category</th>
                        <th class="center aligned">GPU</th>
                        <th class="center aligned">Published</th>
                        <th class="center aligned">type</th>
                        <th>Links</th>
                        <th>Actions</th>
                        <th>Created</th>
                        <th>Modified</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plugins as $plugin)
                    <tr>
                        <td>{{ $plugin->id }}</td>
                        <td>{{ $plugin->name }}</td>
                        <td>{{ $plugin->namespace }}</td>
                        <td><small>{{ $plugin->categories['name'] ?? '' }}</small></td>
                        <td>{{ $plugin->gpusupport }}</td>
                        <td class="text-center"><small>@if(!empty($plugin->version_published)) {{ \Carbon\Carbon::parse($plugin->version_published)->format('Y-m-d') }} @endif</small></td>
                        <td class="text-center">
                            @if ($plugin->type == "PyScript")
                                <i class="far fa-file-alt" title="{{ $plugin->type }}"></i>
                            @else
                                <i class="fas fa-file-powerpoint" title="{{ $plugin->type }}"></i>
                            @endif
                        </td>
                        <td>
                            @php
                                $urls = "";
                                if(!empty($plugin['url_website']) && $plugin['url_github'] != $plugin['url_website']) $urls .= '<a href="'.$plugin['url_website'].'" target="_blank">Website</a> | ';
                                if(!empty($plugin['url_github'])) 	$urls .= '<a href="'.$plugin['url_github'].'" target="_blank">Github</a> | ';
                                if(!empty($plugin['url_doom9'])) 	$urls .= '<a href="'.$plugin['url_doom9'].'"target="_blank">Doom9</a> | ';
                                if(!empty($plugin['url_avswiki'])) 	$urls .= '<a href="'.$plugin['url_avswiki'].'" target="_blank">AvsWiki</a>';
                                $urls = trim(trim(trim($urls), "|"));
                            @endphp
                            {!! $urls !!}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="/dashboard/plugins/{{ $plugin->id }}/edit" class="btn btn-secondary btn-sm" role="button">edit</a>
                                {!! Form::open(['route' => ['plugins.destroy', $plugin->id], 'method'  => 'DELETE', 'onclick' => 'return confirm("Delete '.$plugin->name.' ?")']) !!}
                                {!! Form::submit('delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                        <td><small>{{ $plugin->created_at }}</small></td>
                        <td><small>{{ $plugin->updated_at }}</small></td>
                    </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
