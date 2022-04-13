<?php

use App\Models\Assignment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_joins', function (Blueprint $table) {
            $table->id();
            $table->string('checkpoint');
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('initiated_ts');
            $table->timestamp('ended_ts')->nullable();
        });

        Schema::table('assignment_joins', function (Blueprint $table) {
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
        Schema::dropIfExists('assignment_joins');
    }
}
