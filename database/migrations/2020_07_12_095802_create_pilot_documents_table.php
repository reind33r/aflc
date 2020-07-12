<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilot_documents', function (Blueprint $table) {
            $table->id();

            $table->string('race_subdomain');

            $table->string('description');
            $table->enum('type', ['template', 'auto_template', 'external']);
            $table->string('template_url')->nullable();

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
        Schema::dropIfExists('pilot_documents');
    }
}
