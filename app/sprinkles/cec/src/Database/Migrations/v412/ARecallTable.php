<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\System\Bakery\Migration;


class ARecallTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('arecall_details')) {
            $this->schema->create('arecall_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->string('no_plan_units', 255)->nullable();
                $table->string('record_duration', 255)->nullable();
                $table->string('srp_cleaning', 255)->nullable();
                $table->string('srp_cleaning_units', 255)->nullable();
                $table->string('srp_dr_exam', 255)->nullable();
                $table->string('srp_no', 255)->nullable();
                $table->string('perio_units', 255)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('arecall_details');
    }
}
