<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_opportunities', function (Blueprint $table) {
            $table->id();

            $table->string('race_subdomain');

            $table->string('description');
            $table->datetime('from')->nullable()->default(null);
            $table->datetime('to')->nullable()->default(null);

            $table->unsignedSmallInteger('fee_per_team');
            $table->unsignedSmallInteger('fee_per_pilot');
            $table->unsignedSmallInteger('fee_per_soapbox');

            $table->boolean('soft_limits')->default(false);
            $table->unsignedTinyInteger('team_limit')->nullable()->default(null);
            $table->unsignedTinyInteger('pilot_limit')->nullable()->default(null);
            $table->unsignedTinyInteger('soapbox_limit')->nullable()->default(null);

            $table->boolean('teasing')->default(False);

            $table->foreign('race_subdomain')
                  ->references('subdomain')->on('races')
                  ->onDelete('cascade')
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
        Schema::dropIfExists('registration_opportunities');
    }
}
