<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Datum extends Model {

	protected $fillable = ['filing_id', 'pattern_id', 'value', 'source'];

  public function pattern()
  {
    return $this->belongsTo(Pattern::class);
  }

  public function filing()
  {
    return $this->belongsTo(Filing::class);
  }

}
