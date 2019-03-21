<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class DentistTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('dentist_details')) {
            $this->schema->create('dentist_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
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
        $this->schema->drop('dentist_details');
    }
}
