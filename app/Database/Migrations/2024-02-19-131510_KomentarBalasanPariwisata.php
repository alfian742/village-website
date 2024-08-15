<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KomentarBalasanPariwisata extends Migration
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
            'email' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'deskripsi' => [
                'type'          => 'TEXT',
                'null'  => true,
            ],
            'komentar_pariwisata_id' => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'unsigned'      => true,
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
        $this->forge->createTable('komentar_balasan_pariwisata');
    }

    public function down()
    {
        $this->forge->dropTable('komentar_balasan_pariwisata');
    }
}
