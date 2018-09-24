@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif {!! Form::token() !!}


<div class="row">
    <div class="col-md-5">
        <div class="form-group"><b>Type:</b><br>
            <label>Plugin </label> {!! Form::radio('type', 'VSPlugin', false, ['class'=> '','style'=> 'margin-right: 20px;']) !!}
            <label>Script </label> {!! Form::radio('type', 'PyScript') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('namespace', 'Namespace') !!}
            {!! Form::text('namespace', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('identifier', 'Identifier') !!}
            {!! Form::text('identifier', null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('shortalias', 'Shortalias') !!}
            {!! Form::text('shortalias', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('categories_id', 'Category') !!}
            {!! Form::select('categories_id', $categories->pluck('name', 'id'), $plugin->categories_id ?? "", ['placeholder' => 'Pick a category...','class' => 'form-control']) !!}

        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('gpusupport', 'Has GPU-Support? (Cuda, OpenCL, ...)') !!}
            {!! Form::text('gpusupport', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('dependencies', 'Dependencies (comma seperated!)') !!}
            {!! Form::textarea('dependencies', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <hr>
    </div>
    <div class="col-auto">Web links</div>
    <div class="col-5">
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('url_website', 'Url website') !!}
            {!! Form::text('url_website', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('url_github', 'Url github') !!}
            {!! Form::text('url_github', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('url_doom9', 'Url doom9') !!}
            {!! Form::text('url_doom9', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('url_avswiki', 'Url avswiki') !!}
            {!! Form::text('url_avswiki', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
