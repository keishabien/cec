<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v420;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class StatusTable extends Migration
{


    public function up()
    {
        if (!$this->schema->hasTable('status')) {
            $this->schema->create('status', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('record', 50);
                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
            });
        }
    }

    public function down()
    {
        $this->schema->drop('status');
    }
}
