<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

      public function up(): void
      {
          Schema::table('amlyat', function (Blueprint $table) {
              $table->integer('amlya')->nullable()->change(); // تغيير الحقل إلى نوع رقم (integer)
              $table->date('date')->nullable()->change(); // تغيير الحقل إلى نوع تاريخ (date)
          });
      }

      public function down(): void
      {
          Schema::table('amlyat', function (Blueprint $table) {
              $table->string('amlya')->nullable()->change(); // إعادة `amlya` إلى نوع نصي
              $table->integer('date')->nullable()->change(); // إعادة `date` إلى نوع عدد صحيح
          });
      }

};
