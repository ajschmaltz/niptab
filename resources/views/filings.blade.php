@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
      <div class="row">
        <h1>Filings</h1>
        <hr/>
        <p>I'd like to make this a form, but in the interest of time, it's a link with the common function.</p>
        <a href="/filings?data=0&type=3">Show 10-K Filings without Data</a> | <a href="/filings?data=0&type=4">Show 10-Q Filings without Data</a>
        <hr/>
        <div class="col-md-8">
          {!! $filings->render() !!}
        </div>
        <div class="col-md-4 text-right">
          <div style="margin-top: 20px;" class="btn-group" role="group" aria-label="...">
            <a class="btn btn-success" href="/filings/download">Download</a>
          </div>
        </div>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Type</th>
            <th>Link</th>
          </tr>
        </thead>
        <tbody>
          @forelse($filings as $filing)
            <tr>
              <td>{{ $filing->id }}</td>
              <td>{{ $filing->ticker->symbol }}</td>
              <td>{{ $filing->type->name }}</td>
              <td><a target="_blank" href="{{ $filing->link }}">{{ $filing->link }}</a></td>
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
      <a class="btn btn-danger pull-right" href="/truncate" style="margin-top: 20px;">Truncate Data</a>
      {!! $filings->render() !!}
	</div>
</div>
@endsection
