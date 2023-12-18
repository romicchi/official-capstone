<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToResourceTable extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->boolean('downloadable')->default(false);
            $table->string('uploader')->nullable();
            $table->timestamp('publish_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('downloadable');
            $table->dropColumn('uploader');
            $table->dropColumn('publish_date');
        });
    }
}