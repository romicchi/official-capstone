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
        $table->unsignedBigInteger('role_id')->default(1);
        $table->string('url');
        $table->integer('year_level')->nullable();
        $table->timestamp('archived_at');
        $table->boolean('archived')->default(1);
        $table->timestamps();

        // Foreign key constraint for the role_id column
        $table->foreign('role_id')->references('id')->on('roles');
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
