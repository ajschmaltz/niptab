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

  public function __construct()
  {
    $this->middleware('auth');
  }

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

  public function showFilings(Request $request)
  {

    $filings = Filing::query();

    if($request->has('data')) {
      $filings->has('data', 0);
    }

    return view('filings')->withFilings($filings->paginate(50));
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
    return view('create-type')->withTypes(['1', '1-A', '1-E', '1-N', '10', '10-D', '10-K', '10-M', '10-Q', '11-K', '12b-25', '13F', '13H', '144', '15', '15F', '17-H', '18', '18-K', '19b-4', '19b-4(e)', '19b-7', '2-A', '2-E', '20-F', '24F-2', '25', '3', '4', '40-F', '5', '6-K', '7-M', '8-A', '8-K', '8-M', '9-M', 'ABS-15G', 'ADV', 'ADV-E', 'ADV-H', 'ADV-NR', 'ADV-W', 'ATS', 'ATS-R', 'BD', 'BD-N', 'BDW', 'CA-1', 'CB', 'D', 'F-1', 'F-3', 'F-4', 'F-6', 'F-7', 'F-8', 'F-80', 'F-N', 'F-X', 'ID', 'MA', 'MA-I', 'MA-NR', 'MA-W', 'MSD', 'MSDW', 'N-14', 'N-17D-1', 'N-17f-1', 'N-17f-2', 'N-18f-1', 'N-1A', 'N-2', 'N-23c-3', 'N-27D-1', 'N-3', 'N-4', 'N-5', 'N-54A', 'N-54C', 'N-6', 'N-6EI-1', 'N-6F', 'N-8A', 'N-8B-2', 'N-8B-4', 'N-8F', 'N-CSR', 'N-MFP', 'N-PX', 'N-Q', 'N-SAR', 'NRSRO', 'NRSRO', 'PF', 'PILOT', 'R31', 'S-1', 'S-11', 'S-20', 'S-3', 'S-4', 'S-6', 'S-8', 'SD', 'SE', 'SIP', 'T-1', 'T-2', 'T-3', 'T-4', 'T-6', 'TA-1', 'TA-2', 'TA-W', 'TCR', 'TH', 'WB-APP', 'X-17A-19', 'X-17A-5 Part I', 'X-17A-5 Part II', 'X-17A-5 Part II', 'X-17A-5 Part IIA', 'X-17A-5 Part IIB', 'X-17A-5 Part III', 'X-17A-5 Schedule I', 'X-17F-1A']);
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
    Ticker::truncate();
    return back();
  }

  public function showHelp()
  {
    return view('help');
  }

  public function showSearch(Request $request)
  {
    $ticker = Ticker::where('symbol', $request->get('symbol'))->with(['filings', 'filings.type', 'filings.data', 'filings.data.pattern'])->first();
    return view('search')->withTicker($ticker)->withSymbol($request->get('symbol'));
  }

}
