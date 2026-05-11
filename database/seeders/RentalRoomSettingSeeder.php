<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RentalRoomSettingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 席数マスター初期データ（デフォルト3席）
        DB::table('rental_room_settings')->insert([
            'capacity'   => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
