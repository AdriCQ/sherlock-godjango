<?php

use App\Models\Agent;
use App\Models\Assignment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coords', function (Blueprint $table) {
            $table->id();
            $table->string('coordinate');
        });

        Schema::table('coords', function (Blueprint $table) {
            $table->foreignIdFor(Agent::class);
            $table->foreignIdFor(Assignment::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coords');
    }
}
