<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->timestamps();
        });

        Schema::table('races', function (Blueprint $table) {
            $table->unsignedBigInteger('organizer_id')->nullable();

            $table->foreign('organizer_id')
                  ->references('id')->on('organizers')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizers');
        
        Schema::table('races', function (Blueprint $table) {
            $table->dropForeign('organizer_id_foreign');
            $table->dropColumn('organizer_id');
        });
    }
}
