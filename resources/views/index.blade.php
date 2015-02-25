@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
      <div class="row">
        <div class="col-md-8">
          {!! $tickers->render() !!}
        </div>
        <div class="col-md-4 text-right">
          <a style="margin-top: 20px;" class="btn btn-primary" href="/download">Download a CSV</a>
        </div>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Link to Filing</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Holders</th>
            <th>Potential Holders</th>
            <th>Source</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickers as $ticker)
            <tr>
              <td>{{ $ticker->id }}</td>
              <td>{{ $ticker->symbol }}</td>
              @if(!empty($ticker->latest_filing) && $ticker->latest_filing != 'not available')
                <td><a href="{{ $ticker->latest_filing }}">10-K</a></td>
              @else
                <td>Not Available</td>
              @endif
              <td>{{ $ticker->status }}</td>
              <td>{{ $ticker->updated_at }}</td>
              <th>
                @foreach($ticker->holders as $holder)
                  @if ($holder->status == 1)
                    {{ $holder->total }}
                  @endif
                @endforeach
              </th>
              <td>
                @foreach($ticker->holders as $holder)
                  <a href="/mark/{{ $holder->id }}">{{ $holder->total }}</a><br/>
                @endforeach
              </td>
              <td>
                @foreach($ticker->holders as $holder)
                  {{ $holder->source }}<br/>
                @endforeach
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {!! $tickers->render() !!}
	</div>
</div>
@endsection
