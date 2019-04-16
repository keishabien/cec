<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class HygCrecallTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\HygOfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('hyg_crecall')) {
            $this->schema->create('hyg_crecall', function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->integer('office_id')->unsigned();
                $table->integer('hygienist_id')->unsigned();

                $table->string('units', 255)->nullable();
                $table->string('age_range', 255)->nullable();
                $table->string('braces_units', 255)->nullable();
                $table->string('notes', 1000)->nullable();

                $table->integer('status_id')->unsigned();
                $table->timestamps();

                $table->unique('id');

                $table->index(['id','office_id','hygienist_id','status']);

                $table->foreign('office_id')->references('id')->on('office_details');
                $table->foreign('hygienist_id')->references('id')->on('hygienist_details');
                $table->foreign('status_id')->references('id')->on('status');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('hyg_crecall');
    }
}