<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResourceTypeIdToResourcesTable extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_type_id')->nullable();

            $table->foreign('resource_type_id')
                  ->references('id')
                  ->on('resource_types')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign(['resource_type_id']);
            $table->dropColumn('resource_type_id');
        });
    }
}