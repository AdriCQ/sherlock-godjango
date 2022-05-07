<?php

use App\Models\Assignment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentCheckpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coordinate');
            $table->unsignedTinyInteger('status')->default(0);
            $table->string('contact')->nullable();
            $table->timestamp('initiated_ts');
            $table->timestamp('ended_ts')->nullable();
        });

        Schema::table('assignment_checkpoints', function (Blueprint $table) {
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
        Schema::dropIfExists('assignment_checkpoints');
    }
}
