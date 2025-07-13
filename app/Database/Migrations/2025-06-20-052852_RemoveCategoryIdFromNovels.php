<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCategoryIdFromNovels extends Migration
{
    public function up()
    {
        // Hapus foreign key constraint terlebih dahulu
        $this->forge->dropForeignKey('novels', 'novels_category_id_foreign');
        
        // Hapus kolom category_id
        $this->forge->dropColumn('novels', 'category_id');
    }

    public function down()
    {
        // Tambah kembali kolom category_id jika rollback
        $this->forge->addColumn('novels', [
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'author_id'
            ]
        ]);
        
        // Tambah kembali foreign key
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
    }
}
