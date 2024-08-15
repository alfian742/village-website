<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Slider extends Migration
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
            'judul' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'deskripsi' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'relevan_url' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'gambar' => [
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
        $this->forge->createTable('slider');
    }

    public function down()
    {
        $this->forge->dropTable('slider');
    }
}
