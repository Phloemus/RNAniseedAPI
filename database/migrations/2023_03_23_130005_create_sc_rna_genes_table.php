<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScRnaGenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_rna_genes', function (Blueprint $table) {
            $table->id();
            $table->integer('ena_id');
            $table->string('organism');
            $table->string('function');
            $table->string('name');
            $table->boolean('isCharacterized');
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
        Schema::dropIfExists('sc_rna_genes');
    }
}
