<?php namespace App\Http\Controllers;

use App\Holder;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use SimpleHtmlDom\simple_html_dom;
use SoapBox\Formatter\Formatter;
use App\Ticker;
use CSV;

class DataController extends Controller {

  private $html;

  public function __construct(simple_html_dom $html)
  {
    $this->html = $html;
  }

  public function isInvalidXML($file)
  {
    return substr($file, 0, 5) == "<?xml" ? false : true;
  }

  public function hasNoEntry($file)
  {
    return isset($file['entry'][0]) ? false : true;
  }

  public function getLatestFiling(Ticker $ticker)
  {

    $symbol = str_replace(' ', '', $ticker->symbol);

    $filings_link = "http://www.sec.gov/cgi-bin/browse-edgar?action=getcompany&CIK=$symbol&type=10-k%25&dateb=&owner=exclude&start=0&count=10&output=atom";

    $filings = file_get_contents($filings_link);

    if($this->isInvalidXML($filings)) {
      $ticker->latest_filing = '';
      $ticker->status = 2;
      return $ticker->save();
    }

    $filings = Formatter::make(
      $filings,
      Formatter::XML
    )->toArray();

    if($this->hasNoEntry($filings)){
      $ticker->latest_filing = '';
      $ticker->status = 2;
      return $ticker->save();
    }

    $entry = array_first($filings['entry'], function($key, $value)
    {
      return $value['content']['filing-type'] == '10-K';
    });


    $filing_index = file_get_contents($entry['link']['@attributes']['href']);

    $ticker->latest_filing = 'http://www.sec.gov' . $this->html->load($filing_index)->find('#formDiv a')[0]->attr['href'];
    $ticker->status = 0;
    return $ticker->save();

  }

  public function getDownload()
  {
    return Ticker::with('holders')->get()->toArray();
    return CSV::create(
      Ticker::with('holders')->get()->toArray()
    )->render();
  }

  public function getMatches($str)
  {
    $pattern = '/(\d+(?:,\d+)?) *(?:registered|common)? *(?:[a-z]+)?holders *of *(?:record|Common *Stock|our *common *stock)/';
    preg_match_all($pattern, $str, $matches, PREG_SET_ORDER);


    if(! $matches){
      $pattern = '/(?:[a-z]+)?holders *of *record *of *our *common *stock *was *(\d+(?:,\d+)?)/';
      preg_match_all($pattern, $str, $matches, PREG_SET_ORDER);
    }

    if(! $matches){
      return null;
    }

    return $matches;

  }

  public function spinHolder($ticker)
  {
    $ticker = Ticker::whereSymbol($ticker)->first();
    $this->getHolders($ticker, 98);
  }

  public function spinHolders()
  {
    $tickers = Ticker::where('latest_filing', '!=', '')
      ->where('status', 0)
      ->take(5)
      ->orderBy('updated_at')
      ->get();

    foreach($tickers as $ticker){
      print $ticker->symbol . '<br/>';
      $this->getHolders($ticker, 1);
    }

    // lets do some that have failed...

    $tickers = Ticker::where('latest_filing', '!=', '')
      ->where('status', 1)
      ->take(5)
      ->orderBy('updated_at')
      ->get();

    foreach($tickers as $ticker){
      foreach($ticker->holders as $holder){
        $holder->delete();
      }
      print $ticker->symbol . '<br/>';
      $this->getHolders($ticker, 98);
    }




  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function getHolders(Ticker $ticker, $status)
  {

    $ticker->status = $status;
    $ticker->save();

    $filing = strip_tags(
      html_entity_decode(file_get_contents($ticker->latest_filing))
    );

    $matches = $this->getMatches($filing);

    if(is_array($matches)){

      foreach($matches as $match){

        if($match){
          $ticker->holders()->create([
            'total' => str_replace(',', '', $match[1]),
            'source' => $match[0]
          ]);
        }

      }

    }

  }

  public function loadTickers()
  {

    $data = file_get_contents(public_path() . '/nyse.csv');
    $formatter = Formatter::make($data, Formatter::CSV);

    $this->saveTickers($formatter->toArray(), 'NYSE');

    $data = file_get_contents(public_path() . '/nasdaq.csv');
    $formatter = Formatter::make($data, Formatter::CSV);

    $this->saveTickers($formatter->toArray(), 'NASDAQ');

    $data = file_get_contents(public_path() . '/amex.csv');
    $formatter = Formatter::make($data, Formatter::CSV);

    $this->saveTickers($formatter->toArray(), 'AMEX');

  }

  public function saveTickers($tickers, $exchange)
  {
    foreach($tickers as $ticker){
      Ticker::create([
        'symbol' => $ticker['Symbol'],
        'exchange' => $exchange
      ]);
    }
  }

  public function showTickers()
  {
    return view('index')->withTickers(Ticker::paginate(50));
  }

  public function spin()
  {
    $tickers = Ticker::where('status', '!=', 3)->take(5)->orderBy('updated_at')->get();

    foreach($tickers as $ticker){
      $this->getLatestFiling($ticker);
    }

  }

  public function spinOnce($ticker)
  {
    $ticker = Ticker::whereSymbol($ticker)->first();
    $this->getLatestFiling($ticker);
  }

  public function markHolder($id)
  {
    Holder::find($id)->update(['status' => 1]);
    return back();
  }

}