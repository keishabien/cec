<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class DoctorTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('doctor_details')) {
            $this->schema->create('doctor_details', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('name', 255)->nullable();
                $table->string('nickname', 255)->nullable();
                $table->string('provider_num', 255)->nullable();
                $table->string('emergency_num', 255)->nullable();
                $table->string('locum', 2)->nullable();
                $table->string('start_date', 25)->nullable();
                $table->string('end_date', 25)->nullable();
                $table->string('leave', 2)->nullable();
                $table->string('leave_start_date', 25)->nullable();
                $table->string('leave_end_date', 25)->nullable();
                $table->string('notes', 1000)->nullable();

                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->foreign('status_id')->references('id')->on('status');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('doctor_details');
    }
}
