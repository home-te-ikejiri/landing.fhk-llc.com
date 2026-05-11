<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_room_time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedTinyInteger('hour')->comment('時間（0〜23）');
            $table->tinyInteger('is_blocked')->default(0)->comment('0:制限なし 1:管理者都合で不可');
            $table->string('admin_memo', 255)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->unique(['date', 'hour']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_room_time_slots');
    }
};
