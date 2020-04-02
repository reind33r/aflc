<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCMSMenusTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('cms_menu', function (Blueprint $table) {
        //     $table->bigIncrements('id');

        //     $table->string('race_subdomain');
        //     $table->string('name');

        //     $table->foreign('race_subdomain')
        //           ->references('subdomain')->on('races')
        //           ->onDelete('cascade')
        //           ->onUpdate('cascade');
        // });


        Schema::create('cms_menu_item', function (Blueprint $table) {
            $table->string('race_subdomain');

            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->string('name');
            $table->string('cms_page_uri')->nullable();
            $table->string('internal_link')->nullable();
            $table->string('external_link')->nullable();
            $table->enum('visibility', [
                'all',
                'race_registered',
                'race_not_registered',
                'race_organizer'
            ])->nullable();
            $table->unsignedTinyInteger('order')->default(0);

            $table->foreign('race_subdomain')
                  ->references('subdomain')->on('races')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign(['race_subdomain', 'cms_page_uri'])
                  ->references(['race_subdomain', 'uri'])->on('cms_pages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            

            // $table->unsignedBigInteger('cms_menu_id');
            // $table->foreign('cms_menu_id')
            //       ->references('id')->on('cms_menu')
            //       ->onDelete('cascade')
            //       ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('cms_menu');
        Schema::dropIfExists('cms_menu_item');
    }
}
