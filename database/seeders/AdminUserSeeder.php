<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::query()->updateOrCreate(
            ['email' => 'admin@canaldedenuncias.local'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin1234!'),
            ],
        );
    }
}
