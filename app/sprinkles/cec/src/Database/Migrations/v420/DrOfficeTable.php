<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class DrOfficeTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DoctorTable'

    ];

    public function up()
    {
        if (!$this->schema->hasTable('dr_off')) {
            $this->schema->create('dr_off', function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->integer('office_details_id')->unsigned();
                $table->integer('doctor_details_id')->unsigned();
                $table->timestamps();

                $table->unique('id');

                $table->index(['id','office_details_id','doctor_details_id']);
                $table->foreign('office_details_id')->references('id')->on('office_details');
                $table->foreign('doctor_details_id')->references('id')->on('doctor_details');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('dr_off');
    }
}
