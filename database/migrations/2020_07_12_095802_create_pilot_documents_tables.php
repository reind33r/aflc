<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotDocumentsTables extends Migration
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


        Schema::create('m2m_pilot_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('pilot_document_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('pilot_document_id')
                  ->references('id')->on('pilot_documents')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign(['team_id', 'user_id'])
                  ->references(['team_id', 'user_id'])->on('team_pilot')
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
        Schema::dropIfExists('m2m_pilot_documents');
    }
}
