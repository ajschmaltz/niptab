@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Create a Pattern</h1>
      @if (empty($types->toArray()))
        <div class="alert alert-danger">
          <strong>Warning:</strong> You can not create a pattern until you have <a href="/types/create">created a type</a>.
        </div>
      @else
        <p class="lead">Patterns are ran with php's preg_find_all.  There should only be one matching group containing the specific value.  The matched phrase will also be saved as the source.</p>
        <strong>Working examples for holders of record:</strong>
        <pre>/(\d+(?:,\d+)?) *(?:registered|common)? *(?:[a-z]+)?holders *of *(?:record|Common *Stock|our *common *stock)/</pre>
        <pre>/(?:[a-z]+)?holders *of *record *of *our *common *stock *was *(\d+(?:,\d+)?)/</pre>
        <hr />
        {!! Form::open() !!}
        <div class="form-group">
          {!! Form::label('Finds:') !!}
          {!! Form::text('finds', null, ['class' => 'form-control', 'placeholder' => 'Example: Number of Holders']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('Pattern:') !!}
          {!! Form::text('pattern', null, ['class' => 'form-control', 'placeholder' => 'The Regular Expression']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('Type:') !!}
          {!! Form::select('type_id',$types->lists('name', 'id') , null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    @endif
  </div>
</div>
@endsection