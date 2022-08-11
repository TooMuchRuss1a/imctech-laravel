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
        Schema::create('errors', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->string('username')->nullable();
            $table->string('method')->nullable();
            $table->string('uri')->nullable();
            $table->text('where')->nullable();
            $table->string('agent')->nullable();
            $table->text('message')->nullable();
            $table->text('data')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('errors');
    }
};
