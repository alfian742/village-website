<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Geografis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'lokasi' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'luas' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'timur' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'barat' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'selatan' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'utara' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
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
        $this->forge->createTable('geografis');
    }

    public function down()
    {
        $this->forge->dropTable('geografis');
    }
}
