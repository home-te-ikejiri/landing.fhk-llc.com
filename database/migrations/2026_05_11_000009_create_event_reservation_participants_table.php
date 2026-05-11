<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_reservation_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_reservation_id')->constrained('event_reservations')->cascadeOnDelete();
            $table->string('name', 100);
            $table->integer('sort_order')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index('event_reservation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_reservation_participants');
    }
};
