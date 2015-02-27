<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapBox\Formatter\Formatter;
use App\Ticker;

class TickerController extends Controller {

  public function uploadTickers(Request $request)
  {
    $data = file_get_contents($request->file('csv')->getRealPath());
    $formatter = Formatter::make($data, Formatter::CSV);

    $this->saveTickers($formatter->toArray());

    return redirect('tickers');
  }

  public function saveTickers($tickers)
  {
    foreach($tickers as $ticker){
      Ticker::create([
        'symbol' => $ticker['Symbol']
      ]);
    }
  }

}
