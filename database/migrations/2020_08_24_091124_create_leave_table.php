<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("users_id");
            $table->text('date_leave'); // array tanggal sakit
            $table->smallInteger('amount');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->text("note")->nullable();
            $table->bigInteger("request_to")->nullable(); // users id (atasan yg bisa melakukan approve / rejected)
            $table->text("note_from_manager")->nullable();
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
        Schema::dropIfExists('leave');
    }
}
