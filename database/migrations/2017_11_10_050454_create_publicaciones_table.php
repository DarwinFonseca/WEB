<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
          $table->increments('id_publicacion')->references('id_publicacion')->on('publicacionesxusuarios')->onDelete('cascade');
          $table->string('descripcion');
          $table->string('link');
          $table->integer('votos');
          $table->integer('comentarios');
          $table->string('estado');
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
        Schema::dropIfExists('publicaciones');
    }
}
