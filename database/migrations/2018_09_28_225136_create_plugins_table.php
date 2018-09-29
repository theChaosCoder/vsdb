<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePluginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins', function (Blueprint $table) {
            $table->increments('id');
			$table->string('namespace', 191);
			$table->string('shortalias', 191);
			$table->string('identifier', 191);
			$table->string('name', 191);
			$table->unsignedInteger('categories_id');
			$table->string('version', 191);
			$table->string('version_published', 191);
			$table->string('type', 191);
			$table->string('gpusupport', 191);
			$table->boolean('vs_included')->default('0');;
			$table->string('url_github', 191);
			$table->string('url_doom9', 191);
			$table->string('url_avswiki', 191);
			$table->string('url_website', 191);
			$table->boolean('vsrepo')->default('0');
			$table->text('releases');
			$table->text('description');
			$table->string('deprecated', 191);
			$table->text('dependencies');
            $table->timestamps();
			$table->softDeletes();
			
			$table->index('namespace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins');
    }
}
