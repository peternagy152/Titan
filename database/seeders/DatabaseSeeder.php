<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Peter" ,
                "last_name" => "Nagy" ,
                "email" => "peter.nagy@mitchdesigns.com" ,
                "password" =>  Hash::make("peter123"),
                "phone" => "01111111214" ,
                "role" => "admin" ,
            ],
            [
                "name" => "Nader" ,
                "last_name" => "Mohamed" ,
                "email" => "nader@gmail.com" ,
                "password" =>  Hash::make("123456"),
                "phone" => "01111111214" ,
                "role" => "admin" ,
            ],
            [
                "name" => "Mitch" ,
                "last_name" => "Designs" ,
                "email" => "admin@mitchdesigns.com" ,
                "password" =>  Hash::make("123456"),
                "phone" => "01111111214" ,
                "role" => "admin" ,
            ]
        ];
        foreach($users as $user){
            User::create($user);
        }

        $this->call([
            PaymentMethodSeeder::class,
            BlogSeeder::class,
            FaqCategorySeeder::class,
            FaqSeeder::class,
            ShopCategorySeeder::class,
            ProductSeeder::class,
            ShopCategoryProductSeeder::class, // Make sure this seeder is created to link products and categories
            CountrySeeder::class,
            CitySeeder::class,
            AreaSeeder::class,
            AddressSeeder::class,
            BranchSeeder::class,
            CouponSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);

    }
}
