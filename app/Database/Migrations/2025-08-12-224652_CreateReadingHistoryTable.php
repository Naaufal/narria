<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReadingHistoryTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'novel_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'chapter_id' => [
                'type' => 'INT',
                'constraint' => 10,
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
        $this->forge->addUniqueKey(['user_id', 'novel_id'], 'unique_user_novel_history');
        $this->forge->addKey('user_id', false, false, 'idx_user_id');
        $this->forge->addKey('novel_id', false, false, 'idx_novel_id');
        $this->forge->addKey('chapter_id', false, false, 'idx_chapter_id');
        $this->forge->addKey('updated_at', false, false, 'idx_updated_at');
        
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', '', 'fk_reading_history_user');
        $this->forge->addForeignKey('novel_id', 'novels', 'id', 'CASCADE', '', 'fk_reading_history_novel');
        $this->forge->addForeignKey('chapter_id', 'chapters', 'id', 'CASCADE', '', 'fk_reading_history_chapter');
        
        $this->forge->createTable('reading_history');
    }

    public function down()
    {
        $this->forge->dropTable('reading_history');
    }
}