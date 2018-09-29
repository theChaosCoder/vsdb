<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugin_functions', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('plugin_id');
			$table->string('name', 191);
			$table->text('description');
			$table->unsignedInteger('categories_id');
			$table->string('bitdepth', 191);
			$table->string('colorspace', 191);
			$table->string('gpusupport', 191);
			$table->text('defaults');
			$table->text('parameters');
			$table->string('deprecated', 191);
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugin_functions');
    }
}
