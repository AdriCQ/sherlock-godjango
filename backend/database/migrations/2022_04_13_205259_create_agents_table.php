<?php

use App\Models\AgentGroup;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('nick');
            $table->text('others')->nullable();
            $table->json('position');
            $table->boolean('bussy')->default(false);
            $table->timestamps();
        });

        Schema::table('agents', function (Blueprint $table) {
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(AgentGroup::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
}
