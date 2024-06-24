<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariantIdToBottlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bottles', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->after('id')->nullable();
            $table->string('asin')->after('variant_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bottles', function (Blueprint $table) {
            $table->dropColumn('variant_id');
            $table->dropColumn('asin');
        });
    }
}
