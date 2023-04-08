<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        Schema::create(config('backpack.api-log.table', 'api_logs'), function (Blueprint $table) {
            $table->id();
            $table->string('host')->nullable();
            $table->string('method')->nullable();
            $table->text('url')->nullable();
            $table->string('type')->nullable();
            $table->unsignedInteger('status_code')->nullable();
            $table->string('status_text')->nullable();
            $table->text('request_header')->nullable();
            $table->json('request_body')->nullable();
            $table->json('request_object')->nullable();
            $table->decimal('response_time', 18, 6)->nullable();
            $table->text('response_header')->nullable();
            $table->json('response_body')->nullable();
            $table->json('response_object')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('backpack.api-log.table', 'api_logs'));
    }
};
