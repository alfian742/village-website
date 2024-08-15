<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Situs extends Migration
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
            'nama_desa' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
            ],
            'kecamatan' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
            ],
            'kabupaten' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
            ],
            'provinsi' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100,
            ],
            'kode_pos' => [
                'type'          => 'VARCHAR',
                'constraint'    => 20,
            ],
            'logo' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('situs');
    }

    public function down()
    {
        $this->forge->dropTable('situs');
    }
}
