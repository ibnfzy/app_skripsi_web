<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalSeminar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'seminar_id' => ['type' => 'INT'],
            'tanggal' => ['type' => 'DATE'],
            'waktu' => ['type' => 'TIME'],
            'ruangan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'penguji_id' => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jadwal_seminar');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_seminar');
    }
}