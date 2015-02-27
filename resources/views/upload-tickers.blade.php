@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="row">
        <h1>Upload Ticker File</h1>
        <p class="lead">The ticker file should be in a CSV format.  There is one required column and it must be labeled "Symbol".</p>
        <hr/>
        {!! Form::open(['files' => 'true']) !!}
        <div class="form-group">
          {!! Form::label('csv', 'CSV File:') !!}
          {!! Form::file('csv') !!}
        </div>
        <div class="form-group">
          {!! Form::submit('Upload', ['class' => 'btn-primary']) !!}
        </div>
      </div>
    </div>
  </div>
  @endsection