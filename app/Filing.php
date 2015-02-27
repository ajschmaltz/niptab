<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Filing extends Model {

  protected $fillable = ['type_id', 'link'];

	public function ticker()
  {
    return $this->belongsTo(Ticker::class);
  }

  public function type()
  {
    return $this->belongsTo(Type::class);
  }

  public function data()
  {
    return $this->hasMany(Datum::class);
  }

}
