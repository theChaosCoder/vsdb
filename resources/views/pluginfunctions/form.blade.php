@include('partials.error')
{!! Form::token() !!}

<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            {!! Form::label('plugin_id', 'Plugin') !!}
            {!! Form::select('plugin_id', $plugins->pluck('name', 'id'), $pluginfunction->plugin_id ?? "", ['placeholder' => 'Pick a Plugin...','class' => 'form-control standardSelect']) !!}

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
            {!! Form::label('deprecated', 'Deprecated (insert successor)') !!}
            {!! Form::text('deprecated', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('bitdepth', 'Bit depth') !!}
            {!! Form::text('bitdepth', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('colorspace', 'Color space') !!}
            {!! Form::text('colorspace', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            {!! Form::label('categories_id', 'Category') !!}
            {!! Form::select('categories_id', $categories->pluck('name', 'id'), $pluginfunction->categories_id ?? "", ['placeholder' => 'Pick a category...','class' => 'form-control']) !!}

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
