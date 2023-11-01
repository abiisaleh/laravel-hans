<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@demo.com',
            'password' => 'demo1234',
        ]);

        $data = [
            'Kepala Bagian Pemerintahan Umum',
            'Kepala Bagian Pemerintahan Kampung dan Kelurahan',
            'Kepala Bagian Pengembangan Wilayah',
            'Kepala Bagian Pemerintahan Pengkajian dan Pengembangan Otonomi Khusus',
        ];

        foreach ($data as $record) {
            \App\Models\Bagian::create(['nama' => $record]);
        }
    }
}
