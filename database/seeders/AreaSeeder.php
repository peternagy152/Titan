<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        $areas = [
            ['city_id' => $cities->where('name', 'New York')->first()->id, 'name' => 'Manhattan', 'rate' => 4.5],
            ['city_id' => $cities->where('name', 'Toronto')->first()->id, 'name' => 'Downtown', 'rate' => 4.2],
            ['city_id' => $cities->where('name', 'London')->first()->id, 'name' => 'Westminster', 'rate' => 4.7],
            ['city_id' => $cities->where('name', 'Sydney')->first()->id, 'name' => 'Bondi', 'rate' => 4.8],
            ['city_id' => $cities->where('name', 'Berlin')->first()->id, 'name' => 'Mitte', 'rate' => 4.6],
        ];

        foreach ($areas as $area) {
            Area::create($area);
        }
    }
}
