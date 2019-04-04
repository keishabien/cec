<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class HygienistTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('hygienist_details')) {
            $this->schema->create('hygienist_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->integer('dentist_id')->unsigned();
                $table->string('name', 255)->nullable();
                $table->string('nickname', 255)->nullable();
                $table->string('provider_num', 255)->nullable();
                $table->string('start_date', 25)->nullable();
                $table->string('end_date', 25)->nullable();
                $table->string('notes', 1000)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
                $table->foreign('dentist_id')->references('id')->on('dentist_details');
                $table->index('dentist_id');
                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('hygienist_details');
    }
}
