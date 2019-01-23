<?php

use Nur\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /* Do the migration */
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /* Undo the migration */
    public function down()
    {
        $this->schema->dropIfExists('users');
    }
}
