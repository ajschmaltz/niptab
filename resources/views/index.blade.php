@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
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
                  <td>{{ $ticker->id }}</td>
                  <td>{{ $ticker->updated_at }}</td>
                </tr>
              @endforeach
            </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
