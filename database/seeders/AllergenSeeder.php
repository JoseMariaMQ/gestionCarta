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
            url('storage/pictures/sections/gluten.svg'),
            url('storage/pictures/sections/crustaceans.svg'),
            url('storage/pictures/sections/egg.svg'),
            url('storage/pictures/sections/fish.svg'),
            url('storage/pictures/sections/peanuts.svg'),
            url('storage/pictures/sections/soy.svg'),
            url('storage/pictures/sections/dairyProducts.svg'),
            url('storage/pictures/sections/peelFruits.svg'),
            url('storage/pictures/sections/celery.svg'),
            url('storage/pictures/sections/mustard.svg'),
            url('storage/pictures/sections/sesameGrains.svg'),
            url('storage/pictures/sections/sulfurDioxideSulphites.svg'),
            url('storage/pictures/sections/mollusks.svg'),
            url('storage/pictures/sections/lupins.svg')
        ];

        foreach (array_combine($names, $pictures) as $name => $picture) {
            Allergen::create([
                'name' => $name,
                'pictures' => $picture
            ]);
        }

    }
}
