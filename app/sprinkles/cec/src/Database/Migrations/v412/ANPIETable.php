<?php
namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;
class ANPIETable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('anpie_details')) {
            $this->schema->create('anpie_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('office_id')->unsigned();
                $table->string('chair', 255)->nullable();
                $table->string('dr_units', 255)->nullable();
                $table->string('hyg_units', 255)->nullable();
                $table->string('first_visit', 255)->nullable();
                $table->string('cleaning', 255)->nullable();
                $table->string('notes', 512)->nullable();
                $table->timestamps();
                $table->foreign('office_id')->references('office_id')->on('office_details');
                $table->index('office_id');
            });
        }
    }
    public function down()
    {
        $this->schema->drop('anpie_details');
    }
}
