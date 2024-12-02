<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonException;
use Random\RandomException;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws JsonException
     * @throws RandomException
     */
    public function run(): void
    {
        $fakerEn = Faker::create();
        $fakerAr = Faker::create('ar_SA');
        $cats = FaqCategory::select("id")->get();
        for ($i = 0; $i < 20; $i++) {
              $faqID = DB::table('faqs')->insertGetId([
                'question' => json_encode([
                    'en' => $fakerEn->sentence,
                    'ar' => $fakerAr->address
                ], JSON_THROW_ON_ERROR),
                'answer' => json_encode([
                    'en' => $fakerEn->sentence,
                    'ar' => $fakerAr->address,
                ], JSON_THROW_ON_ERROR),

                'created_at' => now(),
                'updated_at' => now(),
            ]);

              DB::table('category_faq')->insert([
                  'faq_id' => $faqID,
                  "category_id" => $cats[random_int(0, count($cats) - 1)]->id,
              ]);

        }
    }
}
