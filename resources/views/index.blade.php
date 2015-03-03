@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
      <h1>Data</h1>
      <hr/>
      <div class="row">
        <div class="col-md-8">
          {!! $data->render() !!}
        </div>
        <div class="col-md-4 text-right">
          <div style="margin-top: 20px;" class="btn-group" role="group" aria-label="...">
            <a class="btn btn-success" href="/data/download">Download</a>
          </div>
        </div>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Filing</th>
            <th>Last Updated</th>
            <th>Found</th>
            <th>Value</th>
            <th>Source</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $datum)
            <tr>
              <td>{{ $datum->id }}</td>
              <td>{{ $datum->filing }}</td>
              <td>{{ $datum->updated_at->format("F j, Y, g:i a") }}</td>
              <td>{{ $datum->pattern->finds }}</td>
              <th>{{ $datum->value }}</th>
              <td>{{ $datum->source }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <div class="well">There is no data to show.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <a class="btn btn-danger pull-right" href="/truncate" style="margin-top: 20px;">Truncate Data</a>
      {!! $data->render() !!}
    </div>
</div>
@endsection
