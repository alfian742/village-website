<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DokumenPublik extends Migration
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
            'nama' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'tipe' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'ukuran' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'berkas' => [
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
        $this->forge->createTable('dokumen_publik');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen_publik');
    }
}
