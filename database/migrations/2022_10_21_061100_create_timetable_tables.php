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
        Schema::create('timetable_days', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->string('place');
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('timetable_timelines', function (Blueprint $table) {
            $table->id();
            $table->time('from');
            $table->time('to');
            $table->text('description');
            $table->foreignId('day_id')->constrained('timetable_days')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable_days', function (Blueprint $table) {
            Schema::dropIfExists('timetable_days');
        });
        Schema::table('timetable_timelines', function (Blueprint $table) {
            Schema::dropIfExists('timetable_timelines');
        });
    }
};
