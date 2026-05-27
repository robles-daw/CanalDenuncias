<?php

namespace Database\Seeders;

use App\Models\CausaDenuncia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CausaDenunciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $causas = [
            'Acoso laboral o sexual',
            'Conflictos de interes',
            'Delitos informaticos',
            'Discriminacion',
            'Falsificacion de documentos',
            'Fraude o corrupcion',
            'Incumplimientos legales',
            'Manipulacion financiera o contable',
            'Riesgos graves para la salud o seguridad',
            'Robo o apropiacion indebida',
            'Sobornos',
            'Uso indebido de datos personales',
            'Uso indebido de recursos de la empresa',
            'Vulneraciones del codigo etico',
        ];

        $slugs = collect($causas)
            ->map(fn (string $nombre): string => Str::slug($nombre))
            ->all();

        CausaDenuncia::query()
            ->whereNotIn('slug', $slugs)
            ->update(['activa' => false]);

        foreach ($causas as $orden => $nombre) {
            CausaDenuncia::query()->updateOrCreate(
                ['slug' => Str::slug($nombre)],
                [
                    'nombre' => $nombre,
                    'orden' => $orden + 1,
                    'activa' => true,
                ],
            );
        }
    }
}
