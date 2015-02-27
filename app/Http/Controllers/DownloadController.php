<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller {

	public function downloadData()
  {
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
