<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNovelsTable extends Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'author_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'cover_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'sinopsis' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'views' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'average_rating' => [
                'type' => 'DECIMAL',
                'constraint' => '3,2',
                'default' => 0.00,
            ],
            'total_ratings' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['ongoing', 'completed', 'hiatus'],
                'default' => 'ongoing',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['author_id', 'status', 'views'], false, false, 'idx_author_status_views');
        $this->forge->addKey(['status', 'created_at'], false, false, 'idx_status_created');
        $this->forge->addKey('views', false, false, 'idx_views_desc');
        $this->forge->addKey('average_rating', false, false, 'idx_average_rating');
        
        $this->forge->addForeignKey('author_id', 'users', 'id', 'CASCADE', 'CASCADE', 'novels_author_id_foreign');
        
        $this->forge->createTable('novels');
        
        // Add fulltext index
        $this->db->query('ALTER TABLE novels ADD FULLTEXT(title, sinopsis)');
    }

    public function down()
    {
        $this->forge->dropTable('novels');
    }
}