<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TentangDesa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'tentang_desa' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'visi' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'misi' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'created_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
            'updated_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tentang');
    }

    public function down()
    {
        $this->forge->dropTable('tentang');
    }
}
