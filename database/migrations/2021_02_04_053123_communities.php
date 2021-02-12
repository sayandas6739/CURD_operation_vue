<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Communities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->Increments('id');
            $table->Integer('state_id');
            $table->Integer('city_id');
            $table->string('name');
            $table->string('location');
            $table->string('marker');
            $table->string('slug');
            $table->string('logo');
            $table->string('banner');
            $table->string('text');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_number');
            $table->string('gallery');
            $table->string('lat');
            $table->string('lng');
            $table->Integer('map_zoom');
            $table->string('map_type_id');
            $table->string('nearby');
            $table->string('phases');
            $table->Integer('status_id') -> unique();
            $table->string('type');
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
        //
    }
}
