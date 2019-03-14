<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

class CRecallTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('crecall_details')) {
            $this->schema->create('crecall_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned()->unique();
                $table->string('age_range', 255)->nullable();
                $table->string('braces_units', 255)->nullable();
                $table->string('dr_units', 255)->nullable();
                $table->string('hyg_units', 255)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('crecall_details');
    }
}