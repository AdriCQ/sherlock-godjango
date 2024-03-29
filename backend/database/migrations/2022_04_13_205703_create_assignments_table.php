<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();;
            $table->string('observations')->nullable();
            $table->string('event')->nullable();;
            $table->unsignedTinyInteger('status')->default(0);
            // $table->string('coordinates');
            $table->unsignedBigInteger('agent_id')->nullable();
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
