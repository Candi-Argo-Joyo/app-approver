<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_jabatan')->nullable();
            $table->string('jabatan_name')->nullable();
            $table->bigInteger('id_divisi')->nullable();
            $table->string('divisi_name')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->enum('role', ['administrator', 'manager', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('is_mapping')->default('false');
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
        Schema::dropIfExists('users');
    }
}
