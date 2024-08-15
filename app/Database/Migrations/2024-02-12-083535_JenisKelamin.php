<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisKelamin extends Migration
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
            'jenis_kelamin' => [
                'type'          => 'VARCHAR',
                'constraint'    => 10,
            ],
            'jumlah' => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
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
        $this->forge->createTable('jenis_kelamin');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_kelamin');
    }
}
