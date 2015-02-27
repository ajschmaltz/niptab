<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {

	protected $fillable = ['name'];

  public function filings()
  {
    return $this->hasMany(Filing::class);
  }

  public function patterns()
  {
    return $this->hasMany(Pattern::class);
  }

}
