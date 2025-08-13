<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChaptersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'novel_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'content' => [
                'type' => 'LONGTEXT',
            ],
            'views' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'chapter_number' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->addKey('views', false, false, 'idx_views');
        $this->forge->addKey(['novel_id', 'chapter_number'], false, false, 'idx_novel_chapter_order');
        $this->forge->addKey(['novel_id', 'created_at'], false, false, 'idx_novel_created');
        
        $this->forge->addForeignKey('novel_id', 'novels', 'id', 'CASCADE', '', 'chapters_ibfk_1');
        
        $this->forge->createTable('chapters');
        
        // Add fulltext index
        $this->db->query('ALTER TABLE chapters ADD FULLTEXT(title, content)');
    }

    public function down()
    {
        $this->forge->dropTable('chapters');
    }
}