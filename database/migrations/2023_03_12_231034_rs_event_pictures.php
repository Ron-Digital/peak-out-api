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
        Schema::create('rs_event_pictures', function (Blueprint $table) {
            $table->foreignId('creator_user_id')->references('creator_user_id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('media_id')->references('id')->on('medias')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rs_event_pictures');
    }
};
