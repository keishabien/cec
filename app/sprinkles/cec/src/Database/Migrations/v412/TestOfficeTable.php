<?php

namespace UserFrosting\Sprinkle\Cec\Database\Migrations\v412;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

class TestOfficeTable extends Migration
{
    public function up()
    {
        if (!$this->schema->hasTable('test_office_details')) {
            $this->schema->create('test_office_details', function (Blueprint $table) {
                $table->increments('office_id');
                $table->string('page_id', 25)->nullable();
                $table->string('name', 512)->nullable();
                $table->string('phone', 255)->nullable();
                $table->string('fax', 255)->nullable();
                $table->string('masking_number', 255)->nullable();
                $table->string('extension', 50)->nullable();
                $table->string('address', 255)->nullable();
                $table->string('city', 255)->nullable();
                $table->string('state', 255)->nullable();
                $table->string('zip', 5)->nullable();
                $table->string('mon_hours', 255)->nullable();
                $table->string('tue_hours', 255)->nullable();
                $table->string('wed_hours', 255)->nullable();
                $table->string('thu_hours', 255)->nullable();
                $table->string('fri_hours', 255)->nullable();
                $table->string('sat_hours', 255)->nullable();
                $table->string('sun_hours', 255)->nullable();
                $table->string('page_url', 255)->nullable();
                $table->string('vanity_url', 255)->nullable();
                $table->string('map_url', 255)->nullable();
                $table->string('credit_url', 255)->nullable();
                $table->string('google_review_url', 255)->nullable();
                $table->string('df_reviews_url', 255)->nullable();
                $table->string('img_url', 255)->nullable();
                $table->string('news_category', 255)->nullable();
                $table->string('latitue', 20)->nullable();
                $table->string('longitude', 20)->nullable();
                $table->string('directions', 10000)->nullable();
                $table->string('brand', 50)->nullable();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->index('office_id');
            });
        }
    }

    public function down()
    {
        $this->schema->drop('test_office_details');
    }
}
