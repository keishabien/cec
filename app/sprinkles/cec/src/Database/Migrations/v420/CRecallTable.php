<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class CRecallTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\HygienistTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'

    ];

    public function up()
    {
        if (!$this->schema->hasTable('crecall_details')) {
            $this->schema->create('crecall_details', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('office_id')->nullable()->unsigned();
                $table->integer('dentist_id')->nullable()->unsigned();
                $table->integer('hygienist_id')->nullable()->unsigned();

                $table->string('age_range', 255)->nullable();
                $table->string('braces_units', 255)->nullable();
                $table->string('dr_units', 255)->nullable();
                $table->string('hyg_units', 255)->nullable();
                $table->string('notes', 1000)->nullable();

                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->foreign('status_id')->references('id')->on('status');

                $table->foreign('office_id')->references('id')->on('office_details');
                $table->index('office_id');
                $table->foreign('dentist_id')->references('id')->on('dentist_details');
                $table->index('dentist_id');
                $table->foreign('hygienist_id')->references('id')->on('hygienist_details');
                $table->index('hygienist_id');


                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('crecall_details');
    }
}
