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
        Schema::table('journals', function (Blueprint $table) {
            $table->unsignedBigInteger('college_id')->nullable();
            $table->unsignedBigInteger('discipline_id')->nullable();

            $table->foreign('college_id')->references('id')->on('college');
            $table->foreign('discipline_id')->references('id')->on('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign(['college_id']);
            $table->dropForeign(['discipline_id']);

            $table->dropColumn('college_id');
            $table->dropColumn('discipline_id');
        });
    }
};
