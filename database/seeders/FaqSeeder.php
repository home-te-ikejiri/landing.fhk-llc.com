<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // カテゴリIDをname→idで引く
        $categories = DB::table('faq_categories')->pluck('id', 'name');

        $faqs = [
            // ① ご利用について
            [
                'category' => 'ご利用について',
                'title'    => '予約は必要ですか？',
                'body'     => 'はい。事前予約制となっております。空き状況についてはお気軽にお問い合わせください。',
                'disp_order' => 1,
            ],
            [
                'category' => 'ご利用について',
                'title'    => '何人まで利用できますか？',
                'body'     => 'テーブル利用の場合は6名程度までご利用いただけます。テーブルを使わないイベント利用の場合は8名程度までご利用可能です。',
                'disp_order' => 2,
            ],
            [
                'category' => 'ご利用について',
                'title'    => '子どもも利用できますか？',
                'body'     => '保護者同伴の場合のみご利用いただけます。未就学児は無料、小学生以上は1名として料金計算いたします。',
                'disp_order' => 3,
            ],
            [
                'category' => 'ご利用について',
                'title'    => '子どもだけで利用できますか？',
                'body'     => '小学生以下のみでのご利用はできません。',
                'disp_order' => 4,
            ],

            // ② 料金について
            [
                'category' => '料金について',
                'title'    => '「共有利用」と「占有利用」の違いは何ですか？',
                'body'     => '「共有利用」は他のお客様と同じ空間を共有してご利用いただくプランです。「占有利用」はグループのみで空間をご利用いただける貸切プランです。',
                'disp_order' => 1,
            ],
            [
                'category' => '料金について',
                'title'    => '占有利用は何人でも同じ料金ですか？',
                'body'     => 'はい。人数にかかわらず同一料金となります。',
                'disp_order' => 2,
            ],
            [
                'category' => '料金について',
                'title'    => '支払い方法は何がありますか？',
                'body'     => '現在準備中です。現金でのお支払いを基本としております。',
                'disp_order' => 3,
            ],

            // ③ 飲食について
            [
                'category' => '飲食について',
                'title'    => '飲食物の持ち込みはできますか？',
                'body'     => 'はい。飲食物のお持ち込み可能です。',
                'disp_order' => 1,
            ],
            [
                'category' => '飲食について',
                'title'    => 'ドリンクはありますか？',
                'body'     => 'セルフサービスにて、コーヒー・紅茶をご用意しております。',
                'disp_order' => 2,
            ],
            [
                'category' => '飲食について',
                'title'    => 'コーヒーはどのようなものですか？',
                'body'     => '小布施の「クローバーcoffee」さまのコーヒーバッグをご用意しております。お湯を注ぐだけでお楽しみいただけます。',
                'disp_order' => 3,
            ],

            // ④ 設備について
            [
                'category' => '設備について',
                'title'    => 'モニターは利用できますか？',
                'body'     => 'はい。40インチテレビモニター、24インチパソコンモニターをオプションでご利用いただけます。',
                'disp_order' => 1,
            ],
            [
                'category' => '設備について',
                'title'    => 'Wi-Fiは利用できますか？',
                'body'     => 'はい。無料でご利用いただけます。',
                'disp_order' => 2,
            ],

            // ⑤ ご利用時のお願い
            [
                'category' => 'ご利用時のお願い',
                'title'    => '禁止事項はありますか？',
                'body'     => '室内は禁煙です。大音量での音楽再生、近隣のご迷惑となる行為はご遠慮ください。',
                'disp_order' => 1,
            ],
            [
                'category' => 'ご利用時のお願い',
                'title'    => 'ゴミはどうすれば良いですか？',
                'body'     => 'ゴミの分別にご協力をお願いいたします。',
                'disp_order' => 2,
            ],
            [
                'category' => 'ご利用時のお願い',
                'title'    => '利用後に片付けは必要ですか？',
                'body'     => 'ご利用後は簡単な片付けにご協力をお願いいたします。',
                'disp_order' => 3,
            ],

            // ⑥ 営業時間について
            [
                'category' => '営業時間について',
                'title'    => '何時まで利用できますか？',
                'body'     => '最終ご利用時間は17時までとなります。',
                'disp_order' => 1,
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('faqs')->insert([
                'title'       => $faq['title'],
                'category_id' => $categories[$faq['category']],
                'body'        => $faq['body'],
                'disp_order'  => $faq['disp_order'],
                'status'      => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
