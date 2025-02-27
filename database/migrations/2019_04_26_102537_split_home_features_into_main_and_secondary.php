<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SplitHomeFeaturesIntoMainAndSecondary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('page_home_main_home_feature', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'home_feature');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('page_home_secondary_home_feature', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'home_feature');
            $table->integer('position')->unsigned()->index();

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
        Schema::dropIfExists('page_home_main_home_feature');
        Schema::dropIfExists('page_home_secondary_home_feature');
    }
}
