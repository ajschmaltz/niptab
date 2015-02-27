@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Types</h1>
      <hr/>
      <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4 text-right">
          <div style="margin-top: 20px;" class="btn-group" role="group" aria-label="...">
            <a href="/types/create" class="btn btn-primary">Create a Type</a>
          </div>
        </div>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          @forelse($types as $type)
            <tr>
              <td>{{ $type->id }}</td>
              <td>{{ $type->name }}</td>
              <td><a href="/types/{{ $type->id }}/delete">Delete</a></td>
            </tr>
          @empty
            <tr>
              <td colspan="2">
                <div class="well">There is no data to show.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @endsection
