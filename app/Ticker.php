<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model {

  protected $fillable = ['symbol', 'status'];

  public function holders()
  {
    return $this->hasMany(Holder::class);
  }

  public function filings()
  {
    return $this->hasMany(Filing::class);
  }

  public function datas()
  {
    return $this->hasManyThrough(Datum::class, Filing::class);
  }

}
