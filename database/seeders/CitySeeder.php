<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = Country::all();
        $cities = [
            ['country_id' => $countries->where('code', 'US')->first()->id, 'name' => 'New York'],
            ['country_id' => $countries->where('code', 'CA')->first()->id, 'name' => 'Toronto'],
            ['country_id' => $countries->where('code', 'GB')->first()->id, 'name' => 'London'],
            ['country_id' => $countries->where('code', 'AU')->first()->id, 'name' => 'Sydney'],
            ['country_id' => $countries->where('code', 'DE')->first()->id, 'name' => 'Berlin'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
