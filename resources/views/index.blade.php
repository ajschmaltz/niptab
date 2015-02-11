@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
      {!! $tickers->render() !!}
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Symbol</th>
            <th>Link to Filing</th>
            <th>Last Updated</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tickers as $ticker)
            <tr>
              <td>{{ $ticker->id }}</td>
              <td>{{ $ticker->symbol }}</td>
              @if($ticker->latest_filing != 'not available')
                <td><a href="{{ $ticker->latest_filing }}">10-K</a></td>
              @elseif($ticker->latest_filing = '')
                <td>Not Run Yet</td>
              @else
                <td>Not Available</td>
              @endif
              {{ $ticker->updated_at }}
            </tr>
          @endforeach
        </tbody>
      </table>
      {!! $tickers->render() !!}
	</div>
</div>
@endsection
