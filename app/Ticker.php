<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model {

  protected $fillable = ['symbol', 'exchange'];

  public function holders()
  {
    return $this->hasMany(Holder::class);
  }

}
