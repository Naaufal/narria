<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChapterSeeder extends Seeder
{
    public function run()
    {
        $chapters = [
            // Dilan 1990
            [
                'novel_id' => 1,
                'title' => 'Bab 1: Pertemuan di Sekolah',
                'content' => 'Milea bertemu Dilan di halaman sekolah saat hujan deras turun...',
                'chapter_number' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 1,
                'title' => 'Bab 2: Surat Cinta Pertama',
                'content' => 'Dilan mengirimkan surat cinta lucu kepada Milea lewat temannya...',
                'chapter_number' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 1,
                'title' => 'Bab 3: Geng Motor',
                'content' => 'Dilan memperkenalkan Milea kepada teman-teman geng motornya...',
                'chapter_number' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 1,
                'title' => 'Bab 4: Perselisihan Kecil',
                'content' => 'Milea dan Dilan terlibat salah paham yang membuat hubungan mereka diuji...',
                'chapter_number' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Bumi
            [
                'novel_id' => 2,
                'title' => 'Bab 1: Rahasia di Lemari',
                'content' => 'Raib menemukan pintu misterius yang membawanya ke dunia lain...',
                'chapter_number' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 2,
                'title' => 'Bab 2: Klan Bulan',
                'content' => 'Petualangan Raib, Seli, dan Ali dimulai di Klan Bulan...',
                'chapter_number' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 2,
                'title' => 'Bab 3: Pelatihan Rahasia',
                'content' => 'Raib dan teman-temannya dilatih menggunakan kekuatan spesial mereka...',
                'chapter_number' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 2,
                'title' => 'Bab 4: Pertempuran Pertama',
                'content' => 'Mereka menghadapi musuh pertama di dunia Klan Bulan...',
                'chapter_number' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Negeri 5 Menara
            [
                'novel_id' => 3,
                'title' => 'Bab 1: Menuntut Ilmu',
                'content' => 'Alif meninggalkan kampung halamannya untuk menuntut ilmu di Madani...',
                'chapter_number' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 3,
                'title' => 'Bab 2: Teman Seperjuangan',
                'content' => 'Alif bertemu Raja, Said, Dulmajid, dan lainnya...',
                'chapter_number' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 3,
                'title' => 'Bab 3: Semangat Man Jadda Wajada',
                'content' => 'Alif belajar arti kerja keras dalam pelajaran dan kehidupan...',
                'chapter_number' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 3,
                'title' => 'Bab 4: Menatap Menara',
                'content' => 'Mereka bermimpi suatu saat akan menaklukkan dunia dari menara impian mereka...',
                'chapter_number' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Ayat-Ayat Cinta
            [
                'novel_id' => 4,
                'title' => 'Bab 1: Kehidupan di Mesir',
                'content' => 'Fahri berjuang menyelesaikan kuliahnya di Universitas Al Azhar...',
                'chapter_number' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 4,
                'title' => 'Bab 2: Maria, Tetangga Baik',
                'content' => 'Maria mengenal Fahri dari kebiasaannya membaca Al-Quran...',
                'chapter_number' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 4,
                'title' => 'Bab 3: Fitnah yang Menimpa',
                'content' => 'Fahri dituduh tanpa bukti dan harus membela dirinya di pengadilan...',
                'chapter_number' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'novel_id' => 4,
                'title' => 'Bab 4: Cinta dan Pengorbanan',
                'content' => 'Di tengah badai fitnah, cinta sejati Fahri diuji...',
                'chapter_number' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('chapters')->insertBatch($chapters);
    }
}
