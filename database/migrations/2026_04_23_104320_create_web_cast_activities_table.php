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
        Schema::create('web_cast_activities', function (Blueprint $table) {
            $table->id();
            // Titles
            $table->string('content_title')->nullable();
            $table->string('activity_name')->nullable();

            // Doctor Name
            $table->string('dr_name')->nullable();

            // Images
            $table->string('thumbnail')->nullable();
            $table->json('slider_images')->nullable();

            // Date
            $table->date('webcast_date')->nullable();
            $table->string('webcast_time')->nullable();

            // Time (3 fields from form)
            $table->tinyInteger('webcast_hour')->nullable();;   // 1–12
            $table->string('webcast_minute', 2)->nullable();;   // 00–55
            $table->enum('webcast_ampm', ['AM', 'PM'])->nullable();;

            // Status
            $table->enum('status', ['upcoming', 'live', 'completed'])->default('upcoming')->nullable();;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_cast_activities');
    }
};
