<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bimbingan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'mahasiswa_id' => ['type' => 'INT'],
            'dosen_id' => ['type' => 'INT'],
            'catatan' => ['type' => 'TEXT'],
            'file_revisi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bimbingan');
    }

    public function down()
    {
        $this->forge->dropTable('bimbingan');
    }
}