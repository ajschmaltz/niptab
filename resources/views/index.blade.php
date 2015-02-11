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
              @if(isset($ticker->latest_filing) && $ticker->latest_filing != 'not available')
                <td><a href="{{ $ticker->latest_filing }}">10-K</a></td>
              @else
                <td>Not Available</td>
              @endif
              <td>{{ $ticker->updated_at }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {!! $tickers->render() !!}
	</div>
</div>
@endsection
