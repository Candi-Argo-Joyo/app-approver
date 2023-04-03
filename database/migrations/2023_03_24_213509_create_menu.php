<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('id_menu_group');
            $table->integer('id_html_form')->nullable();
            $table->integer('id_user_approver')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->integer('parent')->default(0);
            $table->string('name_parent')->nullable();
            $table->string('page')->nullable();
            $table->enum('status', ['active', 'non-active'])->default('non-active');
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
        Schema::dropIfExists('menu');
    }
}
