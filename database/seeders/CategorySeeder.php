<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //  php artisan tinkerでリレーションの確認
    public function run()
    {
        // カテゴリー大
        DB::table('primary_categories')->insert([
            [
                //primary_category_id = 1
                'name' => 'スキンケア',
                'sort_order' => 1,
            ],
            [
                //primary_category_id = 2
                'name' => 'ヘアケア・スタイリング',
                'sort_order' => 2,
            ],
            [
                //primary_category_id = 3
                'name' => 'ボディケア',
                'sort_order' => 3,
            ],
        ]);

        // カテゴリー小
        DB::table('secondary_categories')->insert([
            //スキンケア
            [
                'name' => '化粧品・ローション',
                'sort_order' => 1,
                'primary_category_id' => 1,
            ],
            [
                'name' => '美容液',
                'sort_order' => 2,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'クレンジング',
                'sort_order' => 3,
                'primary_category_id' => 1,
            ],
            //ヘアケア・スタイリング
            [
                'name' => 'シャンプー',
                'sort_order' => 4,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'トリートメント',
                'sort_order' => 5,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'スタイリング剤',
                'sort_order' => 6,
                'primary_category_id' => 2,
            ],
            //ボディケア
            [
                'name' => '石鹸・ボディーソープ',
                'sort_order' => 7,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'ハンドクリーム',
                'sort_order' => 8,
                'primary_category_id' => 3,
            ],
            [
                'name' => 'ボディークリーム',
                'sort_order' => 9,
                'primary_category_id' => 3,
            ],
        ]);
    }
}
