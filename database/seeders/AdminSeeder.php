<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'admin@gmail.com',
            'foto' => 'assets/uploads/users/default.png',
            'password' => bcrypt(12345678),
            'role' => 'admin',
        ]);

        Admin::create([
            'user_id' => $user->id,
            'nama' => 'Administrator',
            'telp' => '082237188923',
            'alamat' => 'Denpasar',
            // 'gelar' => 'S.Kom'
        ]);
    }
}
