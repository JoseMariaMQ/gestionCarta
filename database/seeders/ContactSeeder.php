<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Whatsapp',
            'Phone',
            'Facebook',
            'Instagram',
            'Google Maps'
        ];

        $urls = [
            'https://api.whatsapp.com/send?phone=34633659747',
            'tel:+34633659747',
            'https://www.facebook.com/cukispozuelo',
            'https://www.instagram.com/cukys_pozuelo',
            'https://goo.gl/maps/bFPhWJWHZgdqYcK78'
        ];

        foreach (array_combine($names, $urls) as $name => $url) {
            Contact::create([
                'name' => $name,
                'url' => $url
            ]);
        }
    }
}
