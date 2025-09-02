<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('exam_catalogs', function (Blueprint $table) {
        $table->string('start_url')->nullable()->after('is_visible_to_students');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('exam_catalogs', function (Blueprint $table) {
        $table->dropColumn('start_url');
    });
}


};
