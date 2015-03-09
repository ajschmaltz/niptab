<?php namespace App\Commands;

use App\Commands\Command;
use App\Ticker;
use App\Type;
use Illuminate\Contracts\Bus\SelfHandling;
use SimpleHtmlDom\simple_html_dom;
use SoapBox\Formatter\Formatter;

class GetAllFilingsForTicker extends Command implements SelfHandling {

  protected  $html;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
    $this->html = new simple_html_dom;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
    Ticker::take(5)->orderBy('updated_at')->get()->each(function($ticker){
      $ticker->touch();
      $this->getFilingsByType($ticker);
    });
	}

  public function getFilingsByType($ticker)
  {
    Type::all()->each(function($type) use ($ticker) {
      $this->getLatestFiling($ticker, $type);
    });
  }

  public function getLatestFiling(Ticker $ticker, Type $type)
  {

    $filings = $this->getFilingList($ticker->symbol, $type->name);

    if($this->isInvalidXML($filings)) {
      // list is invalid xml
      return null;
    }

    $filings = Formatter::make(
      $filings,
      Formatter::XML
    )->toArray();

    if($this->hasNoEntry($filings)){
      // list has no entries
      return null;
    }

    $ticker->filings()->create([
      'type_id' => $type->id,
      'link' => $this->getLinkToFiling($filings, $type->name),
    ]);

  }

  public function getFilingList($symbol, $type_of_filing)
  {
    $symbol = str_replace(' ', '', $symbol);
    $link =  "http://www.sec.gov/cgi-bin/browse-edgar?action=getcompany&CIK=$symbol&type=$type_of_filing&dateb=&owner=exclude&start=0&count=10&output=atom";

    return file_get_contents($link);
  }

  public function getLinkToFiling($filings, $type)
  {
    $filing = array_first($filings['entry'], function($key, $value) use($type)
    {
      return $value['content']['filing-type'] == $type;
    });

    $filing_index = file_get_contents($filing['link']['@attributes']['href']);

    return 'http://www.sec.gov' . $this->html->load($filing_index)->find('#formDiv a')[0]->attr['href'];
  }

  public function isInvalidXML($file)
  {
    return substr($file, 0, 5) == "<?xml" ? false : true;
  }

  public function hasNoEntry($file)
  {
    return isset($file['entry'][0]) ? false : true;
  }
}
