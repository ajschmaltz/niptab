@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Patterns</h1>
      <hr/>
      <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4 text-right">
          <div style="margin-top: 20px;" class="btn-group" role="group" aria-label="...">
            <a href="/patterns/create" class="btn btn-primary">Create Pattern</a>
          </div>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th>ID</th>
          <th>Finds</th>
          <th>Pattern</th>
          <th>Type</th>
        </tr>
        </thead>
        <tbody>
          @forelse($patterns as $pattern)
            <tr>
              <td>{{ $pattern->id }}</td>
              <td>{{ $pattern->finds }}</td>
              <td>{{ $pattern->pattern }}</td>
              <td>{{ $pattern->type->name }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4">
                <div class="well">There is no data to show.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @endsection
