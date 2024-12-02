<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JsonException;

class BlogSeeder extends Seeder
{
    /**
     * @throws JsonException
     */
    public function run(): void
    {
        $fakerEn = Faker::create();
        $fakerAr = Faker::create('ar_SA');

        for ($i = 0; $i < 300; $i ++) {
            $titleEn = $fakerEn->sentence;
            $slug = Str::slug($titleEn);

            $seo = json_encode([
                'meta_title' => $titleEn,
                'meta_description' => $fakerEn->paragraph,
                'keywords' => implode(', ', $fakerEn->words(5)),
            ], JSON_THROW_ON_ERROR);

            $isScheduled = $fakerEn->boolean(50);
            $isPublished = $isScheduled ? 0 : $fakerEn->boolean(50);

            $scheduledPublishDate = $isScheduled ? $fakerEn->dateTimeBetween('now', '+60 days') : null;

            DB::table('blogs')->insert([
                'title' => json_encode([
                    'en' => $titleEn,
                    'ar' => $fakerAr->address,
                ], JSON_THROW_ON_ERROR),
                'content' => json_encode([
                    'en' => $fakerEn->paragraph,
                    'ar' => $fakerAr->address,
                ], JSON_THROW_ON_ERROR),
                'desc' => json_encode([
                    'en' => $fakerEn->paragraph,
                    'ar' => $fakerAr->address,
                ], JSON_THROW_ON_ERROR),
                'featured_image' => $fakerEn->imageUrl(640, 480, 'nature', true, 'Faker'),
                'slug' => $slug,
                'seo' => $seo,
                'is_published' => $isPublished,
                'is_scheduled' => $isScheduled,
                'scheduled_publish_date' => $scheduledPublishDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
