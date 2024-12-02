<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use JsonException;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws JsonException
     */
    public function run(): void
    {
        $areas = Area::all();

        $branches = [
            [
                'name' => 'Branch 1',
                'area_id' => $areas->where('name', 'Manhattan')->first()->id,
                'username' => 'branch1',
                'password' => bcrypt('password123'),
                'extra_fields' => json_encode(['opening_hours' => '9AM - 5PM'], JSON_THROW_ON_ERROR),
            ],
            [
                'name' => 'Branch 2',
                'area_id' => $areas->where('name', 'Downtown')->first()->id,
                'username' => 'branch2',
                'password' => bcrypt('password123'),
                'extra_fields' => json_encode(['opening_hours' => '10AM - 6PM'], JSON_THROW_ON_ERROR),
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
