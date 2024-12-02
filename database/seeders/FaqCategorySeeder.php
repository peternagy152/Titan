<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonException;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws JsonException
     */
    public function run(): void
    {
        $fakerEn = Faker::create();
        $fakerAr = Faker::create('ar_SA');

        for ($i = 0; $i < 5; $i++) {
            DB::table('faq_categories')->insert([
                'name' => json_encode([
                    'en' => $fakerEn->text('20'),
                    'ar' => $fakerAr->company,
                ], JSON_THROW_ON_ERROR),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
