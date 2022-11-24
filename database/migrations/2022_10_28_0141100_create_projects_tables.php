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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('subname')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->string('image_d')->nullable();
            $table->string('image_m')->nullable();
            $table->foreignId('leader_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('approved')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('projects_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('agreement')->default(0);
        });

        Schema::create('projects_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects_users', function (Blueprint $table) {
            Schema::dropIfExists('projects_users');
        });

        Schema::table('projects_likes', function (Blueprint $table) {
            Schema::dropIfExists('projects_likes');
        });

        Schema::table('projects', function (Blueprint $table) {
            Schema::dropIfExists('projects');
        });
    }
};
