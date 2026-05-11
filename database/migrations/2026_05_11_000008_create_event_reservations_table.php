<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->integer('num_participants');
            $table->string('representative_name', 100);
            $table->string('representative_phone', 20);
            $table->string('email', 255);
            $table->text('message')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0:仮予約 1:確定 2:キャンセル');
            $table->text('admin_memo')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index('event_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_reservations');
    }
};
