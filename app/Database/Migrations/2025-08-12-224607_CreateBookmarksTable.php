<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
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
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['user_id', 'novel_id'], 'unique_user_novel_bookmark');
        $this->forge->addKey('user_id', false, false, 'idx_user_id');
        $this->forge->addKey('novel_id', false, false, 'idx_novel_id');
        $this->forge->addKey('created_at', false, false, 'idx_created_at');
        
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', '', 'fk_bookmarks_user');
        $this->forge->addForeignKey('novel_id', 'novels', 'id', 'CASCADE', '', 'fk_bookmarks_novel');
        
        $this->forge->createTable('bookmarks');
    }

    public function down()
    {
        $this->forge->dropTable('bookmarks');
    }
}