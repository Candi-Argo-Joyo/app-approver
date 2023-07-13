<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsertForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insert_form', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_html_form');
            $table->bigInteger('id_user');
            $table->string('id_user_validator')->nullable();
            $table->string('user_name');
            $table->string('form_name', 255);
            $table->string('uid');
            $table->string('field_name');
            $table->string('label');
            $table->text('value');
            $table->string('status')->nullable();
            $table->bigInteger('on_step')->nullable();
            $table->string('validate_by')->nullable();
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
        Schema::dropIfExists('insert_form');
    }
}
