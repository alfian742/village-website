<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KepalaDusun extends Migration
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
            'nama' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'nip' => [
                'type'          => 'CHAR',
                'constraint'    => 20,
            ],
            'deskripsi' => [
                'type'          => 'TEXT',
                'null'          => true,
            ],
            'foto' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'staff_id' => [
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
        $this->forge->createTable('kepala_dusun');
    }

    public function down()
    {
        $this->forge->dropTable('kepala_dusun');
    }
}
