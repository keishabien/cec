<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class CNPIETable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('cnpie_details')) {
            $this->schema->create('cnpie_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->integer('dentist_id')->unsigned();
                $table->string('chair', 255)->nullable();
                $table->string('dr_units', 255)->nullable();
                $table->string('hyg_units', 255)->nullable();
                $table->string('first_visit', 255)->nullable();
                $table->string('cleaning', 255)->nullable();
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
        $this->schema->drop('cnpie_details');
    }
}
