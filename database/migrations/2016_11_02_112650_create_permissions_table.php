<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('display_name');
            $table->string('description');
            $table->string('category');
            $table->timestamps();
            $table->softDeletes();

            //----------------------------------------
            $table->string('created_by')->default("");
            $table->integer('created_by_id')->unsigned()->nullable();

            $table->string('approved_by')->default("");
            $table->integer('approved_by_id')->unsigned()->nullable();
            $table->timestamp('approved_at')->nullable();

            //Last user to update. For the other versions see versions(TODO)
            $table->integer('updated_by_id')->unsigned()->nullable();
            $table->string('updated_by')->default("");
            $table->timestamp('pending_at')->nullable()->useCurrent = true ;
            //
            $table->foreign('created_by_id')
                ->references('id')->on('users');

            $table->foreign('approved_by_id')
                ->references('id')->on('users');

            $table->foreign('updated_by_id')
                ->references('id')->on('users');
            //-----------------------------------
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
