<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_number');

            $table->unsignedBigInteger('captain_id');
            $table->unsignedBigInteger('registration_opportunity_id');

            $table->string('name');
            $table->text('team_comments')->nullable();
            $table->text('organizer_comments')->nullable();

            $table->boolean('refused')->default(false);
            $table->datetime('validated')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('captain_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('registration_opportunity_id')
                ->references('id')->on('registration_opportunities')
                ->onDelete('restrict')
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
        Schema::dropIfExists('teams');
    }
}
