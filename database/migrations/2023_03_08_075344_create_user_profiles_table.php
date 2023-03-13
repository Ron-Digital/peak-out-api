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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->enum('status',['person','community'])->nullable();
            $table->text('biography')->nullable();
            $table->double('average_rate')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male','female'])->nullable();
            $table->foreignId('category_id')->nullable()->references('id')->on('categories')->onUpdate('set null')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
