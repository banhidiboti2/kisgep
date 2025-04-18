<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermekekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allProducts = [
            [
                
                'products' => [
                    [
                        'name' => 'Dekopírfűrész',
                        'description' => 'Gyártó: Makita',
                        'price' => 2000,
                        'image' => 'dekopir.png'
                    ],
                    [
                        'name' => 'Asztali Körfűrész',
                        'description' => 'Gyártó: Belle',
                        'price' => 8000,
                        'image' => 'asztali.png'
                    ],
                    [
                        'name' => 'Gyalu',
                        'description' => 'Gyártó: Makita',
                        'price' => 6000,
                        'image' => 'gyalu.png'
                    ],
                    [
                        'name' => 'Felső Marógép',
                        'description' => 'Gyártó: Bosch',
                        'price' => 3000,
                        'image' => 'marogep.png'
                    ],
                    [
                        'name' => 'Szalagfűrész',
                        'description' => 'Gyártó: Elektro',
                        'price' => 5000,
                        'image' => 'szalag.png'
                    ],
                    [
                        'name' => 'Rezgőcsiszoló',
                        'description' => 'Gyártó: JCB',
                        'price' => 3000,
                        'image' => 'csiszolo.png'
                    ],
                    [
                        'name' => 'Egyenes Csiszoló',
                        'description' => 'Gyártó: Bosch',
                        'price' => 4000,
                        'image' => 'egyenes.png'
                    ],
                    [
                        'name' => 'Oszlopos Fúrógép',
                        'description' => 'Gyártó: Dake',
                        'price' => 5000,
                        'image' => 'oszlopos.png'
                    ],
                    [
                        'name' => 'Plazmavágó',
                        'description' => 'Gyártó: Swift',
                        'price' => 7000,
                        'image' => 'plazma.png'
                    ],
                    [
                        'name' => 'Hegesztőgép',
                        'description' => 'Gyártó: Invertec',
                        'price' => 12000,
                        'image' => 'hegeszto.png'
                    ],
                    [
                        'name' => 'Lemezvágó',
                        'description' => 'Gyártó: Extol',
                        'price' => 1000,
                        'image' => 'lemez.png'
                    ],
                    [
                        'name' => 'Esztergagép',
                        'description' => 'Gyártó: Hungsam',
                        'price' => 25000,
                        'image' => 'eszterga.png'
                    ],
                ]
            ],
            [
                
                'products' => [
                    [
                        'name' => 'Fűnyíró',
                        'description' => 'Gyártó: Atlas',
                        'price' => 6000,
                        'image' => 'funyiro.png'
                    ],
                    [
                        'name' => 'Fűkasza',
                        'description' => 'Gyártó: Stihl',
                        'price' => 5000,
                        'image' => 'fukasza.png'
                    ],
                    [
                        'name' => 'Lombfúvó',
                        'description' => 'Gyártó: Stihl',
                        'price' => 3000,
                        'image' => 'lombfuvo.png'
                    ],
                    [
                        'name' => 'Rönkhasító',
                        'description' => 'Gyártó: Cub Cadet',
                        'price' => 15000,
                        'image' => 'ronkhasito.png'
                    ],
                    [
                        'name' => 'Sövénynyíró',
                        'description' => 'Gyártó: Ryobi',
                        'price' => 3000,
                        'image' => 'sovenynyiro.png'
                    ],
                    [
                        'name' => 'Ágaprító',
                        'description' => 'Gyártó: Cub Cadet',
                        'price' => 4000,
                        'image' => 'agaprito.png'
                    ],
                    [
                        'name' => 'Permetező',
                        'description' => 'Gyártó: Firman',
                        'price' => 2000,
                        'image' => 'permetezo.png'
                    ],
                    [
                        'name' => 'Talajfúró',
                        'description' => 'Gyártó: Stihl',
                        'price' => 7000,
                        'image' => 'talajfuro.png'
                    ],
                    [
                        'name' => 'Szivattyú',
                        'description' => 'Gyártó: Firman',
                        'price' => 6000,
                        'image' => 'szivattyu.png'
                    ],
                    [
                        'name' => 'Gyepszellőztető',
                        'description' => 'Gyártó: Ryan',
                        'price' => 5000,
                        'image' => 'gyepszellozteto.png'
                    ],
                    [
                        'name' => 'Magassági Ágvágó',
                        'description' => 'Gyártó: Ryobi',
                        'price' => 4000,
                        'image' => 'magassagi.png'
                    ],
                    [
                        'name' => 'Tuskómaró',
                        'description' => 'Gyártó: Cub Cadet',
                        'price' => 9000,
                        'image' => 'tuskomaro.png'
                    ],
                ]
            ],
            [
               
                'products' => [
                    [
                        'name' => 'Sarokcsiszoló',
                        'description' => 'Gyártó: Makita',
                        'price' => 4000,
                        'image' => 'sarokcsiszolo.png'
                    ],
                    [
                        'name' => 'Fúrógép',
                        'description' => 'Gyártó: Bosch',
                        'price' => 2000,
                        'image' => 'furogep.png'
                    ],
                    [
                        'name' => 'Vésőgép',
                        'description' => 'Gártó: Bosch',
                        'price' => 5000,
                        'image' => 'vesogep.png'
                    ],
                    [
                        'name' => 'Betonkeverő',
                        'description' => 'Gyártó: Leziter',
                        'price' => 13000,
                        'image' => 'betonkevero.png'
                    ],
                    [
                        'name' => 'Lézeres Szintező',
                        'description' => 'Gyártó: Handy',
                        'price' => 7000,
                        'image' => 'lezeres.png'
                    ],
                    [
                        'name' => 'Hőlégfúvó',
                        'description' => 'Gyártó: Expert',
                        'price' => 2000,
                        'image' => 'holegfuvo.png'
                    ],
                    [
                        'name' => 'Magasnyomású Mosó',
                        'description' => 'Gyártó: Kärcher',
                        'price' => 3000,
                        'image' => 'magasnyomasu.png'
                    ],
                    [
                        'name' => 'Köszörű',
                        'description' => 'Gyártó: Crown',
                        'price' => 5000,
                        'image' => 'koszoru.png'
                    ],
                    [
                        'name' => 'Körfűrész',
                        'description' => 'Gyártó: Expert',
                        'price' => 6000,
                        'image' => 'korfuresz.png'
                    ],
                    [
                        'name' => 'Kompresszor',
                        'description' => 'Gyártó: Fubag',
                        'price' => 2000,
                        'image' => 'kompresszor.png'
                    ],
                    [
                        'name' => 'Gérvágó',
                        'description' => 'Gyártó: DeWalt',
                        'price' => 4000,
                        'image' => 'gervago.png'
                    ],
                    [
                        'name' => 'Aszfaltvágó',
                        'description' => 'Gyártó: Ya Yao Qgj',
                        'price' => 10000,
                        'image' => 'aszfaltvago.png'
                    ],
                ]
            ]
        ];

        // Loop through each category and its products, then insert into database
        foreach ($allProducts as $productGroup) {
            foreach ($productGroup['products'] as $product) {
                DB::table('termekek')->insert([
                    'nev' => $product['name'],
                    'leiras' => $product['description'],
                    'ar' => $product['price'],
                    'kep' => $product['image'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}