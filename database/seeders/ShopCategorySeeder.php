<?php

namespace Database\Seeders;

use App\Models\ShopCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => json_encode(['en' => 'Electronics', 'ar' => 'إلكترونيات']),
                'slug' => Str::slug('electronics'),
                'description' => json_encode(['en' => 'Devices, gadgets, and more.', 'ar' => 'أجهزة وأدوات والمزيد.']),
            ],
            [
                'name' => json_encode(['en' => 'Fashion', 'ar' => 'موضة']),
                'slug' => Str::slug('fashion'),
                'description' => json_encode(['en' => 'Clothing, accessories, and footwear.', 'ar' => 'ملابس وإكسسوارات وأحذية.']),
            ],
            [
                'name' => json_encode(['en' => 'Home & Garden', 'ar' => 'المنزل والحديقة']),
                'slug' => Str::slug('home_and_garden'),
                'description' => json_encode(['en' => 'Furniture, décor, and gardening tools.', 'ar' => 'أثاث وزينة وأدوات البستنة.']),
            ],
            [
                'name' => json_encode(['en' => 'Beauty & Health', 'ar' => 'الجمال والصحة']),
                'slug' => Str::slug('beauty_and_health'),
                'description' => json_encode(['en' => 'Skincare, makeup, and wellness products.', 'ar' => 'منتجات العناية بالبشرة والمكياج والصحة.']),
            ],
            [
                'name' => json_encode(['en' => 'Sports & Outdoors', 'ar' => 'الرياضة والهواء الطلق']),
                'slug' => Str::slug('sports_and_outdoors'),
                'description' => json_encode(['en' => 'Sporting goods, outdoor gear, and fitness equipment.', 'ar' => 'مستلزمات الرياضة وأدوات الهواء الطلق ومعدات اللياقة البدنية.']),
            ],
            [
                'name' => json_encode(['en' => 'Toys & Hobbies', 'ar' => 'الألعاب والهوايات']),
                'slug' => Str::slug('toys_and_hobbies'),
                'description' => json_encode(['en' => 'Toys, games, and hobby supplies.', 'ar' => 'ألعاب وهوايات ولوازم التسلية.']),
            ],
            [
                'name' => json_encode(['en' => 'Automotive', 'ar' => 'السيارات']),
                'slug' => Str::slug('automotive'),
                'description' => json_encode(['en' => 'Car accessories, parts, and tools.', 'ar' => 'إكسسوارات السيارات وقطع الغيار والأدوات.']),
            ],
        ];


        foreach ($categories as $category) {
            DB::table("shop_categories")->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'is_visible' => true,
            ]);
        }
    }
}
