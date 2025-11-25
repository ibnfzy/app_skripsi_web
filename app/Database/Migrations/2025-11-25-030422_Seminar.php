<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Seminar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'mahasiswa_id' => ['type' => 'INT'],
            'jenis' => ['type' => 'ENUM("proposal","hasil","tutup")'],
            'status' => ['type' => 'ENUM("diajukan","diverifikasi","dijadwalkan","selesai")', 'default' => 'diajukan'],
            'tanggal_daftar' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('seminar');
    }

    public function down()
    {
        $this->forge->dropTable('seminar');
    }
}