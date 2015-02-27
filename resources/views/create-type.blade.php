@extends('app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Create Filing Type</h1>
        <p class="lead">Filing types must be a valid public filing type.  The system will fetch the latest filing of each type.</p>
        <hr/>
        {!! Form::open() !!}
        <div class="form-group">
          {!! Form::label('Name:') !!}
          {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection