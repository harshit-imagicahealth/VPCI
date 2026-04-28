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
        Schema::dropIfExists('web_cast_activity_resources');

        Schema::create('web_cast_activity_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webcast_activity_id')->nullable();
            $table->foreign('webcast_activity_id')->references('id')->on('web_cast_activities')->onDelete('cascade');

            // Activity type — one per webcast (unique per webcast + activity)
            $table->enum('activity_type', [
                'pre_read',
                'teaser',
                'view_agenda',
                'summary',
            ]);

            // Upload type selected by user
            $table->text('upload_type')->nullable();

            // Fields — filled based on upload_type
            $table->text('pdf_url')->nullable();       // upload_type = pdf
            $table->text('url')->nullable();            // upload_type = url
            $table->text('video_url')->nullable();      // upload_type = video (external url)

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_cast_activity_resources');
    }
};
