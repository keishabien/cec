<?php
namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class DrAnpieTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\DrOfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\StatusTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('dr_anpie')) {
            $this->schema->create('dr_anpie', function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->integer('office_id')->unsigned();
                $table->integer('doctor_id')->unsigned();

                $table->string('units', 255)->nullable();
                $table->string('first_visit', 255)->nullable();
                $table->string('cleaning', 255)->nullable();
                $table->string('notes', 1000)->nullable();
                $table->integer('status_id')->unsigned();
                $table->timestamps();


                $table->unique('id');

                $table->index(['id','office_id','doctor_id','status']);

                $table->foreign('office_id')->references('id')->on('office_details');
                $table->foreign('doctor_id')->references('id')->on('doctor_details');
                $table->foreign('status_id')->references('id')->on('status');

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }
    public function down()
    {
        $this->schema->drop('dr_anpie');
    }
}
