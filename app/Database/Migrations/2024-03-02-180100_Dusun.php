<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dusun extends Migration
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
            'nama_dusun' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'slug' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'deskripsi' => [
                'type'          => 'TEXT',
                'null'  => true,
            ],
            'gambar' => [
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
            'kepala_dusun_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
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
        $this->forge->createTable('dusun');
    }

    public function down()
    {
        $this->forge->dropTable('dusun');
    }
}
