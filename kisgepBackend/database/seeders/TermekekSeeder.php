<?php

namespace Database\Seeders;

use App\Models\Termek;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TermekekSeeder extends Seeder
{
    public function run(): void
    {
        // A termékek adatai
        $termekek = [
    
            [
                'nev' => 'Dekopírfűrész',
                'leiras' => 'Gyártó: Makita',
                'ar' => 2000,
                'kep_fajl' => 'dekopirfuresz.png'
            ],
            [
                'nev' => 'Asztali Körfűrész',
                'leiras' => 'Gyártó: Belle',
                'ar' => 8000,
                'kep_fajl' => 'asztali.png'
            ],
            [
                'nev' => 'Gyalu',
                'leiras' => 'Gyártó: Makita',
                'ar' => 6000,
                'kep_fajl' => 'gyalu.png'
            ],
            [
                'nev' => 'Felső Marógép',
                'leiras' => 'Gyártó: Bosch',
                'ar' => 3000,
                'kep_fajl' => 'felsomaro.png'
            ],
            [
                'nev' => 'Szalagfűrész',
                'leiras' => 'Gyártó: Elektro',
                'ar' => 5000,
                'kep_fajl' => 'szalag.png'
            ],
            [
                'nev' => 'Rezgőcsiszoló',
                'leiras' => 'Gyártó: JCB',
                'ar' => 3000,
                'kep_fajl' => 'rezgocsiszolo.png'
            ],
            [
                'nev' => 'Egyenes Csiszoló',
                'leiras' => 'Gyártó: Bosch',
                'ar' => 4000,
                'kep_fajl' => 'egyenescsiszolo.png'
            ],
            [
                'nev' => 'Oszlopos Fúrógép',
                'leiras' => 'Gyártó: Dake',
                'ar' => 5000,
                'kep_fajl' => 'oszlopos.png'
            ],
            [
                'nev' => 'Plazmavágó',
                'leiras' => 'Gyártó: Swift',
                'ar' => 7000,
                'kep_fajl' => 'plazmavago.png'
            ],
            [
                'nev' => 'Hegesztőgép',
                'leiras' => 'Gyártó: Invertec',
                'ar' => 12000,
                'kep_fajl' => 'hegeszto.png'
            ],
            [
                'nev' => 'Lemezvágó',
                'leiras' => 'Gyártó: Extol',
                'ar' => 12000,
                'kep_fajl' => 'lemezvago.png'
            ],
            [
                'nev' => 'Esztergagép',
                'leiras' => 'Gyártó: Hungsman',
                'ar' => 25000,
                'kep_fajl' => 'eszterga.png'
            ],
            /*-----------------*/
            [
                'nev' => 'Fűnyíró',
                'leiras' => 'Gyártó: Atlas',
                'ar' => 6000,
                'kep_fajl' => 'funyiro.png'
            ],
            [
                'nev' => 'Fűkasza',
                'leiras' => 'Gyártó: Stihl',
                'ar' => 5000,
                'kep_fajl' => 'fukasza.png'
            ],
            [
                'nev' => 'Lombfúvó',
                'leiras' => 'Gyártó: Stihl',
                'ar' => 5000,
                'kep_fajl' => 'lombfuvo.png'
            ],
            [
                'nev' => 'Rönkhasító',
                'leiras' => 'Gyártó: Cub Cadet',
                'ar' => 3000,
                'kep_fajl' => 'ronkhasito.png'
            ],
            [
                'nev' => 'Sövénynyíró',
                'leiras' => 'Gyártó: Ryobi',
                'ar' => 3000,
                'kep_fajl' => 'sovenynyiro.png'
            ],
            [
                'nev' => 'Ágaprító',
                'leiras' => 'Gyártó: Cub Cadet',
                'ar' => 4000,
                'kep_fajl' => 'agaprito.png'
            ],
            [
                'nev' => 'Permetező',
                'leiras' => 'Gyártó: Firman',
                'ar' => 2000,
                'kep_fajl' => 'permetezo.png'
            ],
            [
                'nev' => 'Talafúró',
                'leiras' => 'Gyártó: Firman',
                'ar' => 7000,
                'kep_fajl' => 'talajfuro.png'
            ],
            [
                'nev' => 'Szivattyú',
                'leiras' => 'Gyártó: Firman',
                'ar' => 6000,
                'kep_fajl' => 'szivattyu.png'
            ],
            [
                'nev' => 'Gyepszellőztető',
                'leiras' => 'Gyártó: Ryan',
                'ar' => 5000,
                'kep_fajl' => 'gyep.png'
            ],
            [
                'nev' => 'Magassági Ágvágó',
                'leiras' => 'Gyártó: Ryobi',
                'ar' => 4000,
                'kep_fajl' => 'magassagi.png'
            ],
            [
                'nev' => 'Tuskómaró',
                'leiras' => 'Gyártó: Cub Cadet',
                'ar' => 9000,
                'kep_fajl' => 'tuskomaro.png'
            ],
            /*-------*/
            [
                'nev' => 'Sarokcsiszoló',
                'leiras' => 'Gyártó: Makita',
                'ar' => 4000,
                'kep_fajl' => 'sarokcsiszolo.png'
            ],
            [
                'nev' => 'Fúrógép',
                'leiras' => 'Gyártó: Bosch',
                'ar' => 2000,
                'kep_fajl' => 'furogep.png'
            ],
            [
                'nev' => 'Vésőgép',
                'leiras' => 'Gyártó: Bosch',
                'ar' => 5000,
                'kep_fajl' => 'vesogep.png'
            ],
            [
                'nev' => 'Betonkeverő',
                'leiras' => 'Gyártó: Leziter',
                'ar' => 13000,
                'kep_fajl' => 'betonkevero.png'
            ],
            [
                'nev' => 'Lézeres Szintező',
                'leiras' => 'Gyártó: Handy',
                'ar' => 7000,
                'kep_fajl' => 'lezeres.png'
            ],
            [
                'nev' => 'Hőlégfúvó',
                'leiras' => 'Gyártó: Expert',
                'ar' => 2000,
                'kep_fajl' => 'holegfuvo.png'
            ],
            [
                'nev' => 'Magasnyomású Mosó',
                'leiras' => 'Gyártó: Karcher',
                'ar' => 3000,
                'kep_fajl' => 'magasnyomasu.png'
            ],
            [
                'nev' => 'Köszörűgép',
                'leiras' => 'Gyártó: Crown',
                'ar' => 5000,
                'kep_fajl' => 'koszoru.png'
            ],
            [
                'nev' => 'Körfűrész',
                'leiras' => 'Gyártó: Expert',
                'ar' => 6000,
                'kep_fajl' => 'korfuresz.png'
            ],
            [
                'nev' => 'Kompresszor',
                'leiras' => 'Gyártó: Fubag',
                'ar' => 2000,
                'kep_fajl' => 'kompresszor.png'
            ],
            [
                'nev' => 'Gérvágó',
                'leiras' => 'Gyártó: DeWalt',
                'ar' => 4000,
                'kep_fajl' => 'gervago.png'
            ],
            [
                'nev' => 'Aszfaltvágó',
                'leiras' => 'Gyártó: Ya Yao Qgj',
                'ar' => 10000,
                'kep_fajl' => 'aszfaltvago.png'
            ],
        
        
          
        ];

        $kepekMappa = public_path('seed_kepek');
        
        if (!File::exists($kepekMappa)) {
            File::makeDirectory($kepekMappa, 0755, true);
            $this->command->info("Képek mappa létrehozva: {$kepekMappa}");
            $this->command->info("Kérjük, töltsön fel képeket ebbe a mappába a következő nevekkel: furokalapacs.jpg, akkus_furo.jpg, stb.");
            return;
        }

        $placeholderImagePath = public_path('placeholder.jpg');
        
        if (!File::exists($placeholderImagePath)) {
            $placeholderBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAIAAAD/gAIDAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NUIwNUVCRTQxNTgzMTFFQTk1RTY5MzQyRUVGRjVGOEYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NUIwNUVCRTUxNTgzMTFFQTk1RTY5MzQyRUVGRjVGOEYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo1QjA1RUJFMjE1ODMxMUVBOTVFNjkzNDJFRUZGNUY4RiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo1QjA1RUJFMzE1ODMxMUVBOTVFNjkzNDJFRUZGNUY4RiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PpCDiIIAAAXrSURBVHja7JzfS1NhGMfP2tlsG1mbOCpxmZWZP0pcRhlJEhlEkX9Q1E0XddNFdFUE3dRNQT+giLqoi6CbCsMiiAqzrJSCtKx+WJrLtGlbO32f9YydbefHe/Z6PPt+rzxnZ+ec533e5znP+/Oc96xMkiSGL1gZnwQJkiQJYglJkgSxhCRJglhCkiRBLCFJkiCWkCRJEEtIkiSIJSRJEsQSklbRlvP/SKVS0Wg0HA5PTEz4/f7BwUGfz+dyuZaWlvBvbneCQqGQVqstLS0tLy+vrKysrKzUaDTFxcVKpdJutxsMhng8bjKZOAmiV/rItN1obW3N6/X29/cPDQ2NjY2FQiHUKpXKZDIJAizEXRKJBP6HWvgRlUqVl5fn0ep0uurqaqPR2NDQYLFYdDqd3W4vKyujKjIRHO0Nhx0YGOjs7IR50I9nZ2fRXYvFYoQjlKzVar1er9fr9Q0NDQ0NDRaLpb6+3mAwZO0WsiGICLDp6Wnkw66urqGhIb/fj+e4BPgKmB6MZ3l5ORxot9ubmppaWlpMJlN+fj6vQETB3d7ejszY2dmJMEdXJTDshUwDh4IrdXZ2In3idWxsbGxuboaP5RqIQCyUGAqFvHEhyEEDQS4qKsIz9OvR0dE3b95g1SBYEF5hLgwmg8FgtVpxgGQyKSJBBBAeHxwcfP78OfR3dXUtLi6yP7lQKMRCuLGx8e7du+3t7Tir3++fnJxEjCIYUBjyNP04NjYWCAQ+fvz4/fv3paUl2DCVSqlUKmQDDBs0nJqaun79+vHjx69cudLc3Iy1EYaP9BCK1UMQTl1dXS9evBgZGcGVRFZOsMzDJw4PD9+6devEiRN37twZHh7GAgmaCPIQpFxkppcvX758+TIajUI3mznY97Ozs/fu3Tt69OjTp0+xwDt69Cii/fjx4+Pj45mDYDEMuX/+/Nnc3Hz58uXh4eHNNxb748ePjx07dv/+fTioGAVhMXP27NkfP36IMJfJ7Kf9/f3nzp0LBoNbhj8+dOTIkefPn6dSKYH7z3q5gQn7y5cvmYPsqLRaLS9evIhGoyLcx2QWZAis9+/fZ29cg8Hg9PR0zg+CM0Pgy8tLk5OTmYNgjQdHEjjItm+g/qurqz6fLx6PC20eYwP0LRqNLi8vZw4CcwnvO7mj14A6jyRFcEsJ4yHVkUgkExfZsSUSiXA4bLVaecnV2wLJ3CiZTPr9fjFvMQ8kk9DAwIDQhtkuBUEYRp8OhUKZg2g0mosXL1ZUVAhqlB3cQu66u9fW1mxtrLq6WugDZTpLcerUqVOnTmUS/mVlZU1NTYJYLNMAeuHChQMHDqyurooABHvVU6dOffv2LXODqVSq1tbWiooKoZdiOKBGo7l06dL+/fsRZbziZg9SV1d34cIFMW0Vtm/fvkePHiGJCnO7sL2tQn19/YMHDzB8hQnCyxqyoaHh4cOH+fn5Ihtm/72J3djYeP/+fSxdBXSU/QHi7e7uvnPnjtjW9+mCaDSaixcvdnR0CDDJ7vgeq6ur6+bNm52dnWIeGmR3EaTfv39/7dq1q1evNjU1bWdyLz4QrLhv3Lhx8+ZNIR9b7dYgSLkXL168fPky2u7fv79QKLTvXgZJR0ZGuru7nz171tvbm21F7rZAUkECgQDukt6/f9/T0xOJRLbTPOeS8l5C8j2D1hLpIFtbW8+cOYPn3t7e5eVlLhcK/A+C1aqFhYWPHz9iJI2Ojv6Ox+fYajqdDptGh8NRVVVls9kwrLLnUDQ/IFhUYrn09evXsbGxQCAwMzMDHIwPuENBQQGAHQ6HyWTC87+BxOVPjHL0I8JM/hZwhv6DYMVkdXV1ZWUF8Q/v+BtQCQ0GG4ZUKpVOpyvgjN/vdzu6//Ht9/7VYxJaT9I+PV5mSpIgAg0OAm9qS4JytjvEuCRIgiRIgiRIgiRIgiRIgiSIT/0RYABGkgmwH2qMAwAAAABJRU5ErkJggg==';
            $placeholderImage = base64_decode($placeholderBase64);
            file_put_contents($placeholderImagePath, $placeholderImage);
            $this->command->info("Placeholder kép létrehozva: {$placeholderImagePath}");
        }

        $counter = 0;
        
        foreach ($termekek as $termekAdat) {
            $kepFajl = $termekAdat['kep_fajl'];
            $kepUtvonal = $kepekMappa . '/' . $kepFajl;
            
            if (!File::exists($kepUtvonal)) {
                $this->command->warn("A kép nem található: {$kepUtvonal}");
                $this->command->warn("Helyette a placeholder-t használjuk");
                $kepUtvonal = $placeholderImagePath;
            } else {
                $imageInfo = @getimagesize($kepUtvonal);
                if ($imageInfo === false) {
                    $this->command->warn("A fájl nem érvényes kép: {$kepUtvonal}");
                    $this->command->warn("Helyette a placeholder-t használjuk");
                    $kepUtvonal = $placeholderImagePath;
                } else {
                    $mimeType = $imageInfo['mime'];
                    $supportedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($mimeType, $supportedTypes)) {
                        $this->command->warn("Nem támogatott képformátum ({$mimeType}): {$kepUtvonal}");
                        $this->command->warn("Helyette a placeholder-t használjuk");
                        $kepUtvonal = $placeholderImagePath;
                    } else {
                        $this->command->info("Kép formátum: {$mimeType}");
                    }
                }
            }
            
            try {
                $kepAdat = file_get_contents($kepUtvonal);
                
                Termek::create([
                    'nev' => $termekAdat['nev'],
                    'leiras' => $termekAdat['leiras'],
                    'ar' => $termekAdat['ar'],
                    'kep' => $kepAdat
                ]);
                
                $this->command->info("Termék létrehozva: {$termekAdat['nev']}");
                $counter++;
            } catch (\Exception $e) {
                $this->command->error("Hiba a kép feltöltése során: " . $e->getMessage());
            }
        }
        
        $this->command->info("Összesen {$counter} termék került feltöltésre az adatbázisba.");
    }
}