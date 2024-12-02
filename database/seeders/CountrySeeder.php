<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'flag' => 'us-flag.png'],
            ['name' => 'Canada', 'code' => 'CA', 'flag' => 'ca-flag.png'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'flag' => 'gb-flag.png'],
            ['name' => 'Australia', 'code' => 'AU', 'flag' => 'au-flag.png'],
            ['name' => 'Germany', 'code' => 'DE', 'flag' => 'de-flag.png'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
