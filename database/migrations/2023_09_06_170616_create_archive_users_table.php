<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('archive_users', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('student_number')->unique()->nullable();
        $table->string('firstname');
        $table->string('lastname');
        $table->string('email')->unique;
        $table->unsignedBigInteger('user_id');
        $table->string('role');
        $table->string('url');
        $table->integer('year_level')->nullable();
        $table->timestamp('archived_at');
        $table->boolean('archived')->default(1);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_users');
    }
};
