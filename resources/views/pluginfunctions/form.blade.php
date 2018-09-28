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

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Bit depth <small><span class="badge badge-success float-right mt-1">copy and paste examples</span></small></strong>
            </div>
            <div class="card-body">
                <p class="card-text">Here are some possible combinations. Usually only the first 3 are used.</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">8-16 int / 32 float</li>
                    <li class="list-group-item">8-16 int</li>
                    <li class="list-group-item">8 int</li>
                    <li class="list-group-item">8, 10, 16 int</li>
                    <li class="list-group-item">32 float</li>
                    <li class="list-group-item">16-32 float</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Color space <small><span class="badge badge-success float-right mt-1">copy and paste example</span></small></strong>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group">GRAY, YUV, RGB, YCOCG</li>
                </ul>
                <br>
                <p class="card-text">You can also specify limitations like this:</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">GRAY, YUV420, YUV422, YUV440, YUV444</li>
                    <li class="list-group-item">GRAY, YUV444, RGB</li>
                </ul>

            </div>
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
