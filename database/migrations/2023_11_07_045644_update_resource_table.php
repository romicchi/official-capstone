<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateResourceTable extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('topic')->nullable()->change();
            $table->string('keywords')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->unsignedBigInteger('college_id')->nullable()->change();
            $table->unsignedBigInteger('discipline_id')->nullable()->change();
        });
    }

    public function down()
    {
        // Define the reverse migration if needed
    }
}
