<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model {

	protected $fillable = ['pattern', 'finds', 'type_id'];

  public function type()
  {
    return $this->belongsTo(Type::class);
  }

}
