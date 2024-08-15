<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SaranaPrasarana extends Migration
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
                'type'  => 'VARCHAR',
                'constraint'  => 255,
            ],
            'slug' => [
                'type'  => 'VARCHAR',
                'constraint'  => 255,
            ],
            'deskripsi' => [
                'type'  => 'TEXT',
                'null'  => true,
            ],
            'gambar' => [
                'type'  => 'VARCHAR',
                'constraint'  => 255,
            ],
            'viewer' => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
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
        $this->forge->createTable('sarana_prasarana');
    }

    public function down()
    {
        $this->forge->dropTable('sarana_prasarana');
    }
}
