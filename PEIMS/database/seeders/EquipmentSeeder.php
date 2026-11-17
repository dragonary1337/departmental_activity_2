<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', env('ADMIN_EMAIL', 'admin@peims.test'))->firstOrFail();
        $records = [
            ['Carbon Fiber Paddle', 'paddles', 89.99, '16 mm carbon-fiber face, polymer honeycomb core, elongated handle.', 'available'],
            ['Fiberglass Paddle', 'paddles', 54.50, 'Fiberglass face with a lightweight polymer core and cushioned grip.', 'unavailable'],
            ['Indoor Pickleball Pack', 'balls', 14.99, 'Pack of six indoor balls with larger holes for a controlled bounce.', 'available'],
            ['Outdoor Pickleball Pack', 'balls', 18.99, 'Pack of six durable outdoor balls designed for wind resistance.', 'unavailable'],
            ['Portable Pickleball Net', 'nets', 129.00, '22-foot portable net set with steel frame and carry bag.', 'available'],
            ['Replacement Net', 'nets', 68.00, 'Regulation-size replacement net with center support strap.', 'unavailable'],
            ['Paddle Grip Tape', 'accessories', 8.50, 'Absorbent overgrip tape, three-pack, suitable for standard handles.', 'available'],
            ['Pickleball Equipment Bag', 'accessories', 42.00, 'Padded court bag with paddle sleeves and ventilated ball pocket.', 'unavailable'],
        ];

        foreach ($records as [$name, $category, $price, $description, $status]) {
            Equipment::updateOrCreate(
                ['user_id' => $admin->id, 'equipment_name' => $name],
                [
                    'category' => $category,
                    'unit_price' => $price,
                    'description' => $description,
                    'availability_status' => $status,
                ]
            );
        }
    }
}
