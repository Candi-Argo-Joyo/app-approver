<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtmlForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_form', function (Blueprint $table) {
            $table->id();
            $table->string('form_name');
            $table->text('html_builder');
            $table->text('html_final')->nullable();
            $table->string('status');
            $table->bigInteger('created_by');
            $table->string('pages')->nullable();
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
        Schema::dropIfExists('html_form');
    }
}
