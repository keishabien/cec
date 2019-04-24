<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class DentistTable extends Migration
{
    public static $dependencies = [
<<<<<<< HEAD
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
=======
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable'
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
    ];

    public function up()
    {
<<<<<<< HEAD

        if (!$this->schema->hasTable('dentist_details')) {
            $this->schema->create('dentist_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->nullable()->unsigned();

=======
        if (!$this->schema->hasTable('dentist_details')) {
            $this->schema->create('dentist_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
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
<<<<<<< HEAD

                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->foreign('status_id')->references('id')->on('status');

                $table->foreign('office_id')->references('id')->on('office_details');
                $table->index('office_id');

=======
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
<<<<<<< HEAD
        $this->schema->drop('doctor_details');
=======
        $this->schema->drop('dentist_details');
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
    }
}
