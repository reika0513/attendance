<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correction', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('work_id')->nullable()->unsigned();
            $table->integer('rest_id')->nullable()->unsigned();
            $table->datetime('punch_in')->nullable();
            $table->datetime('punch_out')->nullable();
            $table->datetime('rest_in')->nullable();
            $table->datetime('rest_out')->nullable();
            $table->string('remark', 100)->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('corrections');
    }
}
