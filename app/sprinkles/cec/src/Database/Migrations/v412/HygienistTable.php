<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

class HygienistTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('hygienist_details')) {
            $this->schema->create('hygienist_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned()->unique();
                $table->string('name', 255)->nullable();
                $table->string('provider_num', 255)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('hygienist_details');
    }
}