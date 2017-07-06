<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYamapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yamaps', function (Blueprint $table) {
            $table->increments('map_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('type')->default('yandex#map');
            $table->text('coordinates')->nullable();
            $table->text('placemarks')->nullable();
            $table->text('lines')->nullable();
            $table->text('polygons')->nullable();
            $table->text('routes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yamaps');
    }
}
