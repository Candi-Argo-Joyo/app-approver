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
            // $table->bigInteger('id_menu_group')->nullable();
            $table->bigInteger('id_html_form')->nullable();
            // $table->bigInteger('id_user_approver')->nullable();
            // $table->bigInteger('id_divisi')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('type');
            $table->bigInteger('parent')->default(0);
            $table->string('name_parent')->nullable();
            $table->string('page')->nullable();
            $table->enum('status', ['active', 'non-active'])->default('non-active');
            $table->enum('is_use', ['yes', 'no'])->default('no');
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
