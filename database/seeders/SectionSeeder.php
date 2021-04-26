<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
          'Entrantes',
          'Patatas',
          'Hamburguesas',
          'Guitarras',
          'Baguettes',
          'Pizzas',
          'Paninis',
          'Sandwiches',
          'Perrito Caliente',
          'Kebabs',
          'Gofres',
          'Crepes',
          'Helados',
          'Bebidas'
        ];
        $orders = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 50, 51, 52, 100];

        foreach (array_combine($names, $orders) as $name => $order) {
            Section::create([
                'name' => $name,
                'order' => $order,
                'hidden' => false
            ]);
        }
    }
}
