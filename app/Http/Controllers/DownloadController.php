<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CSV;
use App\Ticker;
use App\Datum;
use App\Filing;
use Schema;

class DownloadController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

	public function downloadData()
  {
    $schema = Schema::getColumnListing('data');
    dd($schema);
    return CSV::create(
      Datum::all()->toArray()
    )->render();
  }

  public function downloadTickers()
  {
    return CSV::create(
      Ticker::all()->toArray()
    )->render();
  }

  public function downloadFilings()
  {
    return CSV::create(
      Filing::all()->toArray()
    )->render();
  }

}
