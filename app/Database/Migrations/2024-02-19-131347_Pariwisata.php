<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pariwisata extends Migration
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
            'judul' => [
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
            'viewer' => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'null'          => true,
            ],
            'gambar' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'user_id' => [
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
        $this->forge->createTable('pariwisata');
    }

    public function down()
    {
        $this->forge->dropTable('pariwisata');
    }
}
