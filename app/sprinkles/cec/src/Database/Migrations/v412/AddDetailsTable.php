<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

class AddDetailsTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('additional_details')) {
            $this->schema->create('additional_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->string('bom_name', 255)->nullable();
                $table->string('bom_number', 255)->nullable();
                $table->string('dr_hyg_plan', 255)->nullable();
                $table->string('family_same_dr', 255)->nullable();
                $table->string('allow_diff_provider', 255)->nullable();
                $table->string('allow_diff_transfer', 255)->nullable();
                $table->string('int_transfer_NPIE', 255)->nullable();
                $table->string('int_transfer_plan', 255)->nullable();
                $table->string('NPIE_blocks_new', 255)->nullable();
                $table->string('NPIE_blocks_request', 255)->nullable();
                $table->string('NPIE_daily_limit', 255)->nullable();
                $table->string('directions', 5000)->nullable();
                $table->string('other', 5000)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('additional_details');
    }
}