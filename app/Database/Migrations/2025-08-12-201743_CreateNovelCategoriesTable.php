<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNovelCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'novel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['novel_id', 'category_id'], 'unique_novel_category');
        $this->forge->addKey('novel_id', false, false, 'idx_novel_id');
        $this->forge->addKey('category_id', false, false, 'idx_category_id');
        $this->forge->addKey(['category_id', 'created_at'], false, false, 'idx_category_created');
        
        $this->forge->addForeignKey('novel_id', 'novels', 'id', 'CASCADE', '', 'fk_novel_categories_novel_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', '', 'fk_novel_categories_category_id');
        
        $this->forge->createTable('novel_categories');
    }

    public function down()
    {
        $this->forge->dropTable('novel_categories');
    }
}