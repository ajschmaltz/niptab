<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pattern;
use App\Type;
use App\Datum;
use App\Ticker;
use App\Filing;

class PageController extends Controller {

  public function showData()
  {
    return view('index')->withData(Datum::paginate(50));
  }

  public function showTickers()
  {
    return view('tickers')->withTickers(Ticker::paginate(50));
  }

  public function uploadTickers()
  {
    return view('upload-tickers');
  }

  public function showFilings()
  {
    return view('filings')->withFilings(Filing::paginate(50));
  }

  public function createPatterns()
  {
    return view('create-pattern')
      ->withTypes(Type::all());
  }

  public function getPatterns()
  {
    return view('patterns')
      ->withPatterns(Pattern::all())
      ->withTypes(Type::all());
  }

  public function createTypes()
  {
    return view('create-type');
  }

  public function getTypes()
  {
    return view('types')
      ->withTypes(Type::all());
  }

  public function getTruncate()
  {
    Datum::truncate();
    Filing::truncate();
    Pattern::truncate();
    Ticker::truncate();
    Type::truncate();
    return back();
  }

}
