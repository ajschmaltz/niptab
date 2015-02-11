<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTickerIdToHolders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::table('holders', function($table)
    {
      $table->integer('ticker_id')->unsigned();
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::table('holders', function($table)
    {
      $table->dropColumn('ticker_id');
    });
	}

}
