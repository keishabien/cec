<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class HygOfficeTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\HygienistTable'

    ];

    public function up()
    {
        if (!$this->schema->hasTable('hyg_off')) {
            $this->schema->create('hyg_off', function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->integer('office_details_id')->unsigned();
                $table->integer('hygienist_details_id')->unsigned();
                $table->timestamps();

                $table->unique('id');

                $table->index(['id','office_details_id','hygienist_details_id']);
                $table->foreign('office_details_id')->references('id')->on('office_details');
                $table->foreign('hygienist_details_id')->references('id')->on('hygienist_details');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('hyg_off');
    }
}
