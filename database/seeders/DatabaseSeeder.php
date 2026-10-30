<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Todo::firstOrCreate(
            ['title' => 'Journaling & baca buku di cafe kota tua ☕'],
            [
                'description' => 'Bawa notes aesthetic, pesan hot latte, dan tulis rencana minggu depan sambil dengerin lofi music.',
                'is_completed' => false,
            ]
        );

        Todo::firstOrCreate(
            ['title' => 'Hunting foto arsitektur vintage & museum 📷'],
            [
                'description' => 'Keliling area heritage kota tua bareng teman, cari sudut estetik buat feed dan moodboard desain.',
                'is_completed' => true,
            ]
        );

        Todo::firstOrCreate(
            ['title' => 'Rapikan playlist belajar & selesaikan tugas 🎧'],
            [
                'description' => 'Update playlist Spotify buat nemenin belajar dan selesaikan draft materi mingguan.',
                'is_completed' => false,
            ]
        );
    }
}
