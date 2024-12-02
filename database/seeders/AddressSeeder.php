<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $countries = Country::all();
        $cities = City::all();
        $areas = Area::all();

        $addresses = [
            [
                'user_id' => $users->first()->id,
                'country_id' => $countries->where('code', 'US')->first()->id,
                'city_id' => $cities->where('name', 'New York')->first()->id,
                'area_id' => $areas->where('name', 'Manhattan')->first()->id,
                'is_default' => true,
                'street' => '123 5th Ave',
                'building_type' => 'Apartment',
                'building_number' => '12A',
                'floor' => '3rd',
                'apartment_number' => '45B',
            ],
            [
                'user_id' => $users->skip(1)->first()->id,
                'country_id' => $countries->where('code', 'CA')->first()->id,
                'city_id' => $cities->where('name', 'Toronto')->first()->id,
                'area_id' => $areas->where('name', 'Downtown')->first()->id,
                'is_default' => true,
                'street' => '456 Queen St',
                'building_type' => 'Condo',
                'building_number' => '8B',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
