<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Contiene gluten',
            'Crustáceos',
            'Huevos',
            'Pescado',
            'Cacahuetes',
            'Soja',
            'Lácteos',
            'Frutos de cáscara',
            'Apio',
            'Mostaza',
            'Granos de sésamo',
            'Dioxido de azufre y sulfitos',
            'Moluscos',
            'Altramuces'
        ];

        $pictures = [
            'gluten.svg',
            'crustaceans.svg',
            'egg.svg',
            'fish.svg',
            'peanuts.svg',
            'soy.svg',
            'dairyProducts.svg',
            'peelFruits.svg',
            'celery.svg',
            'mustard.svg',
            'sesameGrains.svg',
            'sulfurDioxideSulphites.svg',
            'mollusks.svg',
            'lupins.svg'
        ];

        foreach (array_combine($names, $pictures) as $name => $picture) {
            Allergen::create([
                'name' => $name,
                'pictures' => $picture
            ]);
        }

    }
}
