<?php namespace App\Http\Controllers;

use App\Holder;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use SimpleHtmlDom\simple_html_dom;
use SoapBox\Formatter\Formatter;
use App\Ticker;

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
    
    $ticker = str_replace(' ', '', $ticker->symbol);

    $filings_link = "http://www.sec.gov/cgi-bin/browse-edgar?action=getcompany&CIK=$ticker&type=10-k%25&dateb=&owner=exclude&start=0&count=10&output=atom";

    $filings = file_get_contents($filings_link);

    if($this->isInvalidXML($filings)) {
      $ticker->latest_filing = 'not available';
      return $ticker->save();
    }

    $filings = Formatter::make(
      $filings,
      Formatter::XML
    )->toArray();

    if($this->hasNoEntry($filings)){
      $ticker->latest_filing = 'not available';
      return $ticker->save();
    }

    $filing_index = file_get_contents($filings['entry'][0]['link']['@attributes']['href']);

    $ticker->latest_filing = 'http://www.sec.gov' . $this->html->load($filing_index)->find('#formDiv a')[0]->attr['href'];
    return $ticker->save();

  }

  public function getMatches($statement, $str)
  {
    $pattern = '/([\d,]+)\D*' . $statement . '/';
    preg_match_all($pattern, $str, $match, PREG_SET_ORDER);

    if(! $match){
      return null;
    }

    return $match[0];
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function getHolders(Ticker $ticker)
  {

    $filing = file_get_contents($ticker->latest_filing);

    $statements = array();
    $statements = [
      'record holders of the Company',
      'holders of record'
    ];

    foreach($statements as $statement){

      $match = $this->getMatches($statement, $k_file);

      if($match){
        $ticker->holders->create([
          'total' => $match[0],
          'source' => $match[1]
        ]);
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
    return Ticker::all();
  }

  public function spin()
  {
    $tickers = Ticker::take(5)->orderBy('updated_at')->get();

    foreach($tickers as $ticker){
      $this->getLatestFiling($ticker);
    }

  }

}