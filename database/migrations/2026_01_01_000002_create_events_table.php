<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['concert', 'fanmeeting', 'cultural', 'other'])->default('concert');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('duration_days')->default(7); // 7 or 12 days initial duration for free tier
            $table->integer('extension_days')->default(0); // 5 or 7 days extension
            $table->enum('status', ['active', 'expired', 'disabled'])->default('active');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
