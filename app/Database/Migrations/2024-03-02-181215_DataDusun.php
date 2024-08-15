<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataDusun extends Migration
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
            'waktu' => [
                'type'  => 'DATE',
                'null'  => true,
            ],
            'jumlah_lahir' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'jumlah_mati' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'jumlah_masuk' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'jumlah_keluar' => [
                'type'          => 'INT',
                'constraint'    => 11,
            ],
            'dusun_id' => [
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
        $this->forge->createTable('data_dusun');
    }

    public function down()
    {
        $this->forge->dropTable('data_dusun');
    }
}
