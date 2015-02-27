<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Commands\GetAllFilingsForTicker;
use App\Commands\ParseFiling;

class FilingController extends Controller {

  public function getParse()
  {
    $this->dispatch(new ParseFiling);
  }

  public function getLoad()
  {
    $this->dispatch(new GetAllFilingsForTicker);
  }

}
