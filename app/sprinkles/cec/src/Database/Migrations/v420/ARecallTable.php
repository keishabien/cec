<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class ARecallTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
<<<<<<< HEAD
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\HygienistTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
=======
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable'
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
    ];

    public function up()
    {
        if (!$this->schema->hasTable('arecall_details')) {
            $this->schema->create('arecall_details', function (Blueprint $table) {
                $table->increments('id');
<<<<<<< HEAD
                $table->integer('office_id')->nullable()->unsigned();
                $table->integer('dentist_id')->nullable()->unsigned();
                $table->integer('hygienist_id')->nullable()->unsigned();
=======
                $table->integer('office_id')->unsigned();
                $table->integer('dentist_id')->unsigned();
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
                $table->string('no_plan_units', 255)->nullable();
                $table->string('record_duration', 255)->nullable();
                $table->string('srp_cleaning', 255)->nullable();
                $table->string('srp_transfer', 255)->nullable();
                $table->string('srp_cleaning_units', 255)->nullable();
                $table->string('srp_dr_exam', 255)->nullable();
                $table->string('perio_units', 255)->nullable();
                $table->string('notes', 1000)->nullable();
<<<<<<< HEAD
                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->foreign('status_id')->references('id')->on('status');

                $table->foreign('office_id')->references('id')->on('office_details');
                $table->index('office_id');
                $table->foreign('dentist_id')->references('id')->on('dentist_details');
                $table->index('dentist_id');
                $table->foreign('hygienist_id')->references('id')->on('hygienist_details');
                $table->index('hygienist_id');
=======
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
                $table->foreign('dentist_id')->references('id')->on('dentist_details');
                $table->index('dentist_id');
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
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
