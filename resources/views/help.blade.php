@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <h1>Help</h1>
      <hr/>
      <h3>Setting Types of Filings</h3>
      <p>The tool is constantly running through any <a href="/tickers">tickers</a> looking for the lastest filings by <a href="/types">type</a>.</p>
      <p>The filing types it saves is completely up to you.</p>
      <h3>Setting Patterns</h3>
      <p>Patterns are specific to certain <a href="/types">types</a>.  You have to be looking for at least one type of filing before you can specify a pattern to look for.</p>
      <p>The tool is constantly running through the filings and going through them looking for matches to <a href="/patterns">patthers</a>.</p>
      <p>The patterns are a regular expression with one matching group.  The tool will save the matching group as the value and the entire match as the source.</p>
      <h3>Uploading Tickers</h3>
      <p>Tickers are uploaded from CSV files.  The file needs to have one column named "Symbol" with the stock symbol.  It can have additional columns but they wil not be saved.</p>
      <h3>Truncating Data</h3>
      <p>Truncating data erases all data in all tables.  If you have anything you want to save, download the data first.  Remember to save your patterns too.</p>
    </div>
</div>
@endsection