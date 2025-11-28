<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengajuanJudul extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'mahasiswa_id' => ['type' => 'INT'],
            'judul' => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'ENUM("diajukan","disetujui_kaprodi","disetujui_dekan","ditolak")', 'default' => 'diajukan'],
            'jurnal_json' => ['type' => 'JSON'],
            'latar_belakang' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengajuan_judul');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan_judul');
    }
}