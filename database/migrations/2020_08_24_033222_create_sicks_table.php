<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("users_id");
            $table->text('date_sick'); // array tanggal sakit
            $table->smallInteger('amount');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->enum('is_sick_letter', [0,1]);
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
        Schema::dropIfExists('sicks');
    }
}
