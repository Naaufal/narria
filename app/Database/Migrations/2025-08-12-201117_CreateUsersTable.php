<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'author', 'reader'],
                'default' => 'reader',
            ],
            'profile' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'twitter' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'instagram' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
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
        $this->forge->addUniqueKey('email');
        $this->forge->addKey(['role', 'created_at'], false, false, 'idx_role_created');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}