<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u1611143_reg', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('email');
            $table->string('name');
            $table->string('agroup');
            $table->string('vk');
            $table->string('tg');
            $table->string('password');
            $table->text('hash');
            $table->string('email_confirmed');
            $table->string('ban');
            $table->string('is_admin');
            $table->string('reg_date');
            $table->string('last_activity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('u1611143_reg');
    }
};
