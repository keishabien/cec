<?php
namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class HygAnpieTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\OfficeTable',
        '\UserFrosting\Sprinkle\Cec\Database\Migrations\v420\HygOfficeTable'
    ];

    public function up()
    {
        if (!$this->schema->hasTable('hyg_anpie')) {
            $this->schema->create('hyg_anpie', function (Blueprint $table) {
                $table->increments('id')->primary();
                $table->integer('office_id')->unsigned();
                $table->integer('hygienist_id')->unsigned();
                $table->string('units', 255)->nullable();
                $table->string('first_visit', 255)->nullable();
                $table->string('cleaning', 255)->nullable();
                $table->string('notes', 1000)->nullable();
                $table->string('status', 255)->nullable();
                $table->timestamps();


                $table->unique('id');

                $table->index(['id','office_id','hygienist_id']);
                $table->foreign('office_id')->references('id')->on('office_details');
                $table->foreign('hygienist_id')->references('id')->on('hygienist_details');
                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }
    public function down()
    {
        $this->schema->drop('hyg_anpie');
    }
}
