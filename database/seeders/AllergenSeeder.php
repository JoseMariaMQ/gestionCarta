<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

        $urls = [
            url(Storage::disk('public')->url('allergens/pictures/gluten.svg')),
            url(Storage::disk('public')->url('allergens/pictures/crustaceans.svg')),
            url(Storage::disk('public')->url('allergens/pictures/egg.svg')),
            url(Storage::disk('public')->url('allergens/pictures/fish.svg')),
            url(Storage::disk('public')->url('allergens/pictures/peanuts.svg')),
            url(Storage::disk('public')->url('allergens/pictures/soy.svg')),
            url(Storage::disk('public')->url('allergens/pictures/dairyProducts.svg')),
            url(Storage::disk('public')->url('allergens/pictures/peelFruits.svg')),
            url(Storage::disk('public')->url('allergens/pictures/celery.svg')),
            url(Storage::disk('public')->url('allergens/pictures/mustard.svg')),
            url(Storage::disk('public')->url('allergens/pictures/sesameGrains.svg')),
            url(Storage::disk('public')->url('allergens/pictures/sulfurDioxideSulphites.svg')),
            url(Storage::disk('public')->url('allergens/pictures/mollusks.svg')),
            url(Storage::disk('public')->url('allergens/pictures/lupins.svg'))
        ];

        foreach (array_combine($names, $urls) as $name => $url) {
            Allergen::create([
                'name' => $name,
                'url' => $url
            ]);
        }
    }
}
