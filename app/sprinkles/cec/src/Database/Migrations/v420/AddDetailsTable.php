<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class AddDetailsTable extends Migration
{

    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DentistTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('additional_details')) {
            $this->schema->create('additional_details', function (Blueprint $table) {


                $table->increments('id');
                $table->integer('office_id')->nullable()->unsigned();

                $table->string('bom_name', 255)->nullable();
                $table->string('bom_number', 255)->nullable();
                $table->string('dr_hyg_plan', 255)->nullable();
                $table->string('family_same_dr', 255)->nullable();
                $table->string('allow_diff_provider', 255)->nullable();
                $table->string('allow_diff_transfer', 255)->nullable();
                $table->string('int_transfer_NPIE', 255)->nullable();
                $table->string('int_transfer_plan', 255)->nullable();
                $table->string('NPIE_blocks_new', 255)->nullable();
                $table->string('NPIE_blocks_request', 255)->nullable();
                $table->string('NPIE_daily_limit', 255)->nullable();
                $table->string('adult_hyg_units', 255)->nullable();
                $table->string('directions', 5000)->nullable();
                $table->string('notes', 5000)->nullable();


                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->foreign('status_id')->references('id')->on('status');
                $table->foreign('office_id')->references('id')->on('office_details');
                $table->index('office_id');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('additional_details');
    }
}
