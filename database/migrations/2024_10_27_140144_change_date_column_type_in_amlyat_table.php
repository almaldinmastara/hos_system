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
    Schema::table('amlyat', function (Blueprint $table) {
        $table->date('date')->nullable()->change(); // تعديل نوع الحقل إلى date
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('amlyat', function (Blueprint $table) {
        $table->integer('date')->nullable()->change(); // إعادة الحقل إلى integer
    });
}

};
