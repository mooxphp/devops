<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forge_repositories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('repository_url');
            $table->integer('platform');
            $table->string('platform_uid');
            $table->timestamp('last_commit')->nullable();
            $table->integer('deploys_to_project_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    {
        Schema::dropIfExists('forge_repositories');
    }
};
