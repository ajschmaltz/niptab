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
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Filing</th>
            <th>Last Updated</th>
            <th>Finds</th>
            <th>Value</th>
            <th>Source</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data as $datum)
            <tr>
              <td>{{ $datum->id }}</td>
              <td>{{ $datum->filing->ticker->symbol }}</td>
              <td><a href="{{ $datum->filing->link }}">{{ $datum->filing->type->name }}</a></td>
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
      {!! $data->render() !!}
	</div>
</div>
@endsection
