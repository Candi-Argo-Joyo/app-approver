<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_html_form');
            $table->bigInteger('id_validation_group');
            $table->bigInteger('id_user');
            $table->integer('step');
            $table->string('name');
            $table->enum('required', ['yes', 'no'])->nullable();
            $table->string('name_user');
            $table->bigInteger('more_than')->nullable();
            $table->bigInteger('less_than')->nullable();
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
        Schema::dropIfExists('validation');
    }
}
