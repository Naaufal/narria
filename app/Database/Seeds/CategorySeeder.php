<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Romantis', 'slug' => 'romantis'],
            ['name' => 'Fantasi', 'slug' => 'fantasi'],
            ['name' => 'Petualangan', 'slug' => 'petualangan'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Horor', 'slug' => 'horor'],
            ['name' => 'Komedi', 'slug' => 'komedi'],
            ['name' => 'Misteri', 'slug' => 'misteri'],
        ];

        foreach ($categories as $category) {
            $this->db->table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
