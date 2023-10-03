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
        Schema::table('archive_users', function (Blueprint $table) {
            $table->unsignedBigInteger('college_id')->nullable();

            $table->foreign('college_id')->references('id')->on('college');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archive_users', function (Blueprint $table) {
            $table->dropColumn('college_id');
        });
    }
};
