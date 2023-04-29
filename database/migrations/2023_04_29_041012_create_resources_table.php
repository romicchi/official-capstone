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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('topic');
            $table->string('keywords');
            $table->string('author');
            $table->text('description');
            $table->string('resourceType');
            $table->unsignedBigInteger('subject_id'); // Foreign key for subjects table
            $table->unsignedBigInteger('course_id'); // Foreign key for courses table
            $table->boolean('resourceStatus')->default(false);
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('course')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
