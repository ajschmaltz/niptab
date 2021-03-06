@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
      <h1>Tickers</h1>
      <hr/>
      <div class="row">
        <div class="col-md-8">
          {!! $tickers->render() !!}
        </div>
        <div class="col-md-4 text-right">
          <div style="margin-top: 20px;" class="btn-group" role="group" aria-label="...">
            <a class="btn btn-primary" href="/tickers/upload">Upload</a>
            <a class="btn btn-success" href="/tickers/download">Download</a>
          </div>
        </div>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>
          @forelse($tickers as $ticker)
            <tr>
              <td>{{ $ticker->id }}</td>
              <td>{{ $ticker->symbol }}</td>
              <td>{{ $ticker->updated_at->format("F j, Y, g:i a") }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3">
                <div class="well">There is no data to show.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <a class="btn btn-danger pull-right" href="/truncate" style="margin-top: 20px;">Truncate Data</a>
      {!! $tickers->render() !!}
	</div>
</div>
@endsection
