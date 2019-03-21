<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class CRecallTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('crecall_details')) {
            $this->schema->create('crecall_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->string('age_range', 255)->nullable();
                $table->string('braces_units', 255)->nullable();
                $table->string('dr_units', 255)->nullable();
                $table->string('hyg_units', 255)->nullable();
                $table->timestamps();

                $table->foreign('office_id')->references('office_id')->on('uf_office_details');
                $table->index('office_id');
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
