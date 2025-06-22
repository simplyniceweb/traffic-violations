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
            'Driver' => [
                'Driving without license',
                'Expired driver’s license',
                'Reckless driving',
                'Driving under the influence (DUI)',
                'Distracted driving (e.g., using mobile phone)',
                'Overspeeding',
                'Disregarding traffic signs/signals',
                'Counterflowing',
                'Illegal overtaking',
                'Failure to wear seatbelt',
            ],
            'Vehicle' => [
                'Unregistered vehicle',
                'Expired vehicle registration',
                'Smoke belching',
                'No or defective lights',
                'Modified or noisy mufflers',
                'Operating without license plate',
                'Colorum operation (unauthorized public transport)',
                'Obstruction by parked vehicle',
            ],
            'Parking' => [
                'Illegal parking',
                'Double parking',
                'Blocking driveway',
                'Parking on pedestrian lane',
                'Parking near fire hydrant or intersection',
            ],
            'Motorcycle' => [
                'No helmet',
                'More than two passengers on motorcycle',
                'Motorcycle rider not wearing shoes',
                'Children on motorcycles',
            ],
            'PUV' => [
                'Overloading passengers',
                'Loading/unloading at non-designated areas',
                'Refusal to convey passengers',
                'PUV driver not in uniform',
                'No fare matrix displayed',
            ],
            'Tricycle' => [
                'Operating without franchise/permit',
                'Blocking pedestrian lane or driveway',
                'Unauthorized terminal or route',
            ],
            'Behavior' => [
                'Swerving',
                'Tailgating',
                'Road rage / aggressive driving',
                'Racing on public roads',
                'Driving against one-way traffic',
            ],
            'Other' => [
                'Hit and run',
                'Use of emergency lights/sirens (private vehicle)',
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
