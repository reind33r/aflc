<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_info', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('email')->nullable();

            $table->string('fixed_phone')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('mobile_phone')->nullable();

            $table->text('address')->nullable();
            $table->string('zip_code', 5)->nullable();
            $table->string('city')->nullable();

            $table->string('website')->nullable();
            $table->string('facebook_page')->nullable();

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_info_id')->nullable();

            $table->foreign('contact_info_id')
                  ->references('id')->on('contact_info')
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
        Schema::dropIfExists('contact_info');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('contact_info_id_foreign');
            $table->dropColumn('contact_info_id');
        });
    }
}
