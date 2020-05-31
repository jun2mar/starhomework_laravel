<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_homework', function (Blueprint $table) {
            $table->id();
            $table->string('hw_title', 100);
            $table->integer('fk_users_id');
            $table->integer('fk_subject_id');
            $table->string('hw_files', 255)->nullable();
            $table->string('hw_details', 255)->nullable();
            $table->integer('hw_number_teacher');
            $table->float('hw_price', 10, 2);
            $table->integer('hw_deadline')->comment('Number of days');
            $table->dateTime('hw_expirydate')->comment('Hide homework on teacher search');
            $table->string('hw_status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_homework');
    }
}
