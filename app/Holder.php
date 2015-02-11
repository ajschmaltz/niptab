<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Holder extends Model {

  protected $fillable = ['total', 'source'];

	public function ticker()
  {
    return $this->belongsTo(Ticker::class);
  }

}
