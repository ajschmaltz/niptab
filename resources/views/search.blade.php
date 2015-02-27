@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Search: {{ $symbol }}</h1>
      <hr/>
      @if ($ticker)
        <h3>Filings</h3>
        @forelse($ticker->filings as $filing)
          <hr/>
          <strong>Data Found for: <a href="{{ $filing->link }}">{{ $filing->type->name }}</a></strong>
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
            @forelse($filing->data as $datum)
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
        @empty
          <div class="well">There is no data to show.</div>
        @endforelse
          </tbody>
        </table>
      @else
      <div class="well">No search results found.</div>
      @endif
    </div>
</div>
@endsection