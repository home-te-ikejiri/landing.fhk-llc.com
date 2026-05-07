<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            ['name' => 'ご利用について',       'disp_order' => 1, 'status' => 1],
            ['name' => '料金について',           'disp_order' => 2, 'status' => 1],
            ['name' => '飲食について',           'disp_order' => 3, 'status' => 1],
            ['name' => '設備について',           'disp_order' => 4, 'status' => 1],
            ['name' => 'ご利用時のお願い',       'disp_order' => 5, 'status' => 1],
            ['name' => '営業時間について',       'disp_order' => 6, 'status' => 1],
        ];

        foreach ($categories as $category) {
            DB::table('faq_categories')->insert(array_merge($category, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
