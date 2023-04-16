<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproverForForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approver_for_form', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_html_form');
            $table->bigInteger('id_user_approver');
            $table->bigInteger('id_menu');
            $table->bigInteger('id_form_field')->nullable();
            $table->string('name');
            $table->enum('rule', ['true', 'false'])->default('false');
            $table->string('field_condition')->nullable();
            $table->string('condition')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->enum('comparison', ['>', '<'])->nullable();
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
        Schema::dropIfExists('approver_for_form');
    }
}
