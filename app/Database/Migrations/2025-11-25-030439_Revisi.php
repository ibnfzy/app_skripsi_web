<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Revisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'seminar_id' => ['type' => 'INT'],
            'mahasiswa_id' => ['type' => 'INT'],
            'keterangan' => ['type' => 'TEXT'],
            'file_revisi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM("belum_diperiksa","disetujui_dosen","selesai")', 'default' => 'belum_diperiksa'],
            'tanggal' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('revisi');
    }

    public function down()
    {
        $this->forge->dropTable('revisi');
    }
}