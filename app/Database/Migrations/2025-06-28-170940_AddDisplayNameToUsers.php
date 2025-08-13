<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDisplayNameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'username'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'display_name');
    }
}
