<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombre = 'Empresa Demo';

        Empresa::query()->updateOrCreate(
            ['dominio' => 'empresa-demo'],
            [
                'nombre' => $nombre,
                'email' => 'canal@empresademo.es',
                'password' => 'Empresa1234!',
                'slug' => Str::slug($nombre),
                'email_canal_denuncias' => 'canal@empresademo.es',
                'telefono_canal_denuncias' => null,
                'logo' => 'default-logo.svg',
                'pdf' => null,
                'pdf_normativa' => null,
                'color_principal' => '#b24a1b',
                'color_secundario' => '#8e3710',
                'color_inputs' => '#8e3710',
                'politica_privacidad_url' => 'https://empresa-demo.es/politica-de-privacidad',
                'politica_cookies_url' => 'https://empresa-demo.es/politica-de-cookies',
                'aviso_legal_url' => 'https://empresa-demo.es/aviso-legal',
                'activa' => true,
            ],
        );
    }
}
