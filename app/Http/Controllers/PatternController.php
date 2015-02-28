<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pattern;

class PatternController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

	public function savePattern(Request $request)
  {
    Pattern::create([
      'finds' => $request->get('finds'),
      'pattern' => $request->get('pattern'),
      'type_id' => $request->get('type_id')
    ]);

    return redirect('patterns');
  }

  public function deletePattern($id)
  {
    Pattern::destroy($id);
    return back();
  }

}
