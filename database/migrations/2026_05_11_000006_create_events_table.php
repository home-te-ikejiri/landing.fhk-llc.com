<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->integer('price')->default(0);
            $table->string('external_url', 500)->nullable();
            $table->unsignedTinyInteger('status')->default(0)->comment('0:非公開 1:公開 2:終了');
            $table->text('admin_memo')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index('event_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
