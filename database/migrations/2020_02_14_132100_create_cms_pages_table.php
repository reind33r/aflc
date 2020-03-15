<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCMSPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->string('race_subdomain');
            $table->string('uri')->default('');

            $table->string('title');
            $table->longText('content');

            $table->primary(['race_subdomain', 'uri']);
            $table->foreign('race_subdomain')
                  ->references('subdomain')->on('races')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_pages');
    }
}
