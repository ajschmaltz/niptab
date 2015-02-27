<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Type;

class TypeController extends Controller {

  public function saveType(Request $request)
  {
    Type::create([
      'name' => $request->get('name')
    ]);

    return redirect('types');
  }

  public function deleteType($id)
  {
    Type::destroy($id);
    return back();
  }

}
