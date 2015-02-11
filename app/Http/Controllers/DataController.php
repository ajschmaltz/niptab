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

    $symbol = str_replace(' ', '', $ticker->symbol);

    $filings_link = "http://www.sec.gov/cgi-bin/browse-edgar?action=getcompany&CIK=$symbol&type=10-k%25&dateb=&owner=exclude&start=0&count=10&output=atom";

    $filings = file_get_contents($filings_link);

    if($this->isInvalidXML($filings)) {
      $ticker->latest_filing = '';
      return $ticker->save();
    }

    $filings = Formatter::make(
      $filings,
      Formatter::XML
    )->toArray();

    if($this->hasNoEntry($filings)){
      $ticker->latest_filing = '';
      return $ticker->save();
    }

    $filing_index = file_get_contents($filings['entry'][0]['link']['@attributes']['href']);

    $ticker->latest_filing = 'http://www.sec.gov' . $this->html->load($filing_index)->find('#formDiv a')[0]->attr['href'];
    $ticker->status = 0;
    return $ticker->save();

  }

  public function getMatches($statement, $str)
  {
    $pattern = '/([\d,]+)\D*' . $statement . '/';
    preg_match_all($pattern, $str, $matches, PREG_SET_ORDER);

    if(! $matches){
      return null;
    }

    return $matches;
  }

  public function spinHolders()
  {
    $tickers = Ticker::whereStatus(0)
      ->where('latest_filing', '!=', '')
      ->where('latest_filing', '!=', 'not available')
      ->take(5)
      ->orderBy('updated_at')
      ->get();

    foreach($tickers as $ticker){
      $this->getHolders($ticker);
    }

    return Holder::all();

  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function getHolders(Ticker $ticker)
  {

    $ticker->status = 1;
    $ticker->save();

    print $ticker->latest_filing;

    $filing = strip_tags(
      file_get_contents(html_entity_decode($ticker->latest_filing))
    );

    $statements = array();
    $statements = [
      'record holders of the Company',
      'holders of record'
    ];

    foreach($statements as $statement){

      $matches = $this->getMatches($statement, $filing);

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
    $tickers = Ticker::take(5)->orderBy('updated_at')->get();

    foreach($tickers as $ticker){
      $this->getLatestFiling($ticker);
    }

  }

}