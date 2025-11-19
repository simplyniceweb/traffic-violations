<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViolationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ViolationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Vehicle' => [
                'Modified or noisy mufflers',
            ],
            'Parking' => [
                'Illegal parking',
                'Double parking',
                'Blocking driveway',
                'Parking on pedestrian lane',
                'Parking near fire hydrant or intersection',
            ],
            'Tricycle' => [
                'Blocking pedestrian lane or driveway',
            ],
            'Other' => [
                'Hit and run',
                'Obstruction of pedestrian lane',
            ]
        ];

        foreach ($categories as $type => $violations) {
            foreach ($violations as $violation) {
                ViolationCategory::create([
                    'name' => $violation,
                    'type' => $type,
                ]);
            }
        }
    }
}
