@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Test a Pattern</h1>
        {!! Form::open() !!}
        <div class="form-group">
          {!! Form::label('Ticker:') !!}
          {!! Form::text('ticker', null, ['class' => 'form-control', 'placeholder' => 'Enter a ticker symbol']) !!}
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
          {!! Form::submit('Test', ['class' => 'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    @endif
  </div>
</div>
@endsection