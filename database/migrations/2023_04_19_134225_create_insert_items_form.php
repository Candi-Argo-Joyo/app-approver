<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsertItemsForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insert_items_form', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_html_form');
            $table->bigInteger('id_form_field');
            $table->bigInteger('id_group_item');
            $table->bigInteger('id_item');
            $table->string('item_name');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_amount');
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
        Schema::dropIfExists('insert_items_form');
    }
}
