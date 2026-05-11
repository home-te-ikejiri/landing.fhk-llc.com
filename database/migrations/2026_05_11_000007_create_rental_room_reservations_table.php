<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rental_room_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('usage_type')->default(0)->comment('0:共有（席のみ） 1:占有（フロア貸し切り）');
            $table->unsignedTinyInteger('purpose')->default(0)->comment('0:打ち合わせ 1:セミナー 2:イベント 3:席利用 4:その他');
            $table->integer('num_people');
            $table->string('name', 100);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->text('message')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0:仮予約 1:確定 2:受付不可 3:キャンセル');
            $table->text('admin_memo')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index('reservation_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_room_reservations');
    }
};
