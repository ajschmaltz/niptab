<?php namespace App\Commands;

use App\Commands\Command;

use App\Filing;
use App\Pattern;
use Illuminate\Contracts\Bus\SelfHandling;

class ParseFiling extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
    Filing::take(2)->orderBy('updated_at')->get()->each(function($filing){
      dd($filing);
      $filing->touch();
      $this->processFiling($filing);
    });
	}

  public function processFiling(Filing $filing)
  {

    $content = strip_tags(
      html_entity_decode(file_get_contents($filing->link))
    );

    $filing->type->patterns->each(function($pattern) use ($content, $filing){
      $this->parseFiling($filing, $content, $pattern);
    });
  }

  public function parseFiling(Filing $filing, $content, Pattern $pattern)
  {

    preg_match_all($pattern->pattern, $content, $matches, PREG_SET_ORDER);

    foreach($matches as $match){

      $value = str_replace(',', '', $match[1]);
      // TODO: Somehow delete duplicates
      // $filing->data()->where('value', $value)->where('pattern_id', $pattern->id)->delete();

      $filing->data()->create([
        'value' => $value,
        'source' => $match[0],
        'pattern_id' => $pattern->id
      ]);

    }

  }

}
