<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndUrlToArchiveUsersTable extends Migration
{
    public function up()
    {
        Schema::table('archive_users', function (Blueprint $table) {
            $table->string('role'); // Add a column for role
            $table->string('url'); // Add a column for URL
        });
    }

    public function down()
    {
        Schema::table('archive_users', function (Blueprint $table) {
            $table->dropColumn(['role', 'url']);
        });
    }
}

