<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $password = password_hash('password', PASSWORD_DEFAULT);

        $data = [
            [
                'username'   => 'mahasiswa1',
                'password'   => $password,
                'nama'       => 'Mahasiswa Satu',
                'role'       => 'mahasiswa',
                'created_at' => $now,
            ],
            [
                'username'   => 'dosen1',
                'password'   => $password,
                'nama'       => 'Dosen Satu',
                'role'       => 'dosen',
                'created_at' => $now,
            ],
            [
                'username'   => 'kaprodi1',
                'password'   => $password,
                'nama'       => 'Kaprodi Satu',
                'role'       => 'kaprodi',
                'created_at' => $now,
            ],
            [
                'username'   => 'sekjur1',
                'password'   => $password,
                'nama'       => 'Sekretaris Jurusan',
                'role'       => 'sekjur',
                'created_at' => $now,
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
