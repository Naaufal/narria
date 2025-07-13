<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('123456', PASSWORD_DEFAULT);

        // Data Admin
        $admins = [
            [
                'username' => 'naufal',
                'email'    => 'naufal@adminnarria.com',
                'role'     => 'admin',
                'password' => $password,
            ],
            [
                'username' => 'fania',
                'email'    => 'fania@adminnarria.com',
                'role'     => 'admin',
                'password' => $password,
            ],
            [
                'username' => 'ilham',
                'email'    => 'ilham@adminnarria.com',
                'role'     => 'admin',
                'password' => $password,
            ],
            [
                'username' => 'adam',
                'email'    => 'adam@adminnarria.com',
                'role'     => 'admin',
                'password' => $password,
            ],
        ];

        // Data Author (Penulis Indonesia yang sedang trending)
        $authors = [
            ['username' => 'eka_kurniawan', 'email' => 'eka_kurniawan@gmail.com', 'role' => 'author'],
            ['username' => 'boy_candra', 'email' => 'boy_candra@gmail.com', 'role' => 'author'],
            ['username' => 'andreas_kurniawan', 'email' => 'andreas_kurniawan@gmail.com', 'role' => 'author'],
            ['username' => 'grace_tioso', 'email' => 'grace_tioso@gmail.com', 'role' => 'author'],
            ['username' => 'dee_lestari', 'email' => 'dee_lestari@gmail.com', 'role' => 'author'],
            ['username' => 'raditya_dika', 'email' => 'raditya_dika@gmail.com', 'role' => 'author'],
            ['username' => 'cyntha_hariadi', 'email' => 'cyntha_hariadi@gmail.com', 'role' => 'author'],
            ['username' => 'chandra_bientang', 'email' => 'chandra_bientang@gmail.com', 'role' => 'author'],
            ['username' => 'js_khairen', 'email' => 'js_khairen@gmail.com', 'role' => 'author'],
            ['username' => 'naomi_midori', 'email' => 'naomi_midori@gmail.com', 'role' => 'author'],
        ];

        foreach ($authors as &$author) {
            $author['password'] = $password;
        }

        // Data Reader (Menggunakan nama khas Indonesia)
        $readerNames = [
            'andi', 'budi', 'citra', 'dian', 'eka', 'fajar', 'galih', 'hana', 'indra', 'joko',
            'karina', 'lina', 'mario', 'nadia', 'opik', 'putri', 'qory', 'rizki', 'santi', 'taufik',
            'utami', 'vito', 'wulan', 'xaverius', 'yusuf'
        ];

        $readers = [];
        foreach ($readerNames as $name) {
            $readers[] = [
                'username' => $name,
                'email'    => $name . '@gmail.com',
                'role'     => 'reader',
                'password' => $password,
            ];
        }

        // Menggabungkan semua data
        $users = array_merge($admins, $authors, $readers);

        // Memasukkan data ke dalam database
        $this->db->table('users')->insertBatch($users);
    }
}
