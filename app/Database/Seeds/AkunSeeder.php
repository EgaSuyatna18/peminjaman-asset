<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $user = new \App\Models\UserModel();

        $data = [
            [
                'role' => 'Petugas BMN',
                'nama' => 'Petugas BMN',
                'username' => 'petugas',
                'password' => '123'
            ],
            [
                'role' => 'Ketua Bagian Umum',
                'nama' => 'Ketua Bagian Umum',
                'username' => 'ketua',
                'password' => '123'
            ],
            [
                'role' => 'Pengurus Peralatan Pengeboran / Survei Explorasi',
                'nama' => 'Pengurus Peralatan',
                'username' => 'pengurus',
                'password' => '123'
            ],
            [
                'role' => 'Ketua Tim Kelompok Kerja',
                'nama' => 'Ketua Tim',
                'username' => 'ketuatim',
                'password' => '123'
            ],
            [
                'role' => 'Kepala PSDMBP',
                'nama' => 'Kepala PSDMBP',
                'username' => 'kepala',
                'password' => '123'
            ],
        ];
        $user->insertBatch($data);
    }
}
