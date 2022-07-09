<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table){
            $table->foreignIdFor(Client::class);
        });
        Schema::table('assignments', function(Blueprint $table){
            $table->foreignIdFor(Client::class);
        });
        // Schema::table('agent_categories', function(Blueprint $table){
        //     $table->foreignIdFor(Client::class);
        // });
        Schema::table('events', function(Blueprint $table){
            $table->foreignIdFor(Client::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
        // Schema::table('agent_categories', function (Blueprint $table) {
        //     $table->dropColumn('client_id');
        // });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
}
