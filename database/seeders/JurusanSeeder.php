<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;
use App\Models\Kelas;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusans = [
            'Teknik Informatika',
            'Teknik Mesin',
            'Teknik Pendingin'
        ];

        foreach ($jurusans as $jurusanName) {
            // Create Jurusan
            $jurusan = Jurusan::create([
                'nama_jurusan' => $jurusanName
            ]);

            for ($i = 1; $i <= 6; $i++) {
                // Create Prodi
                $prodi = Prodi::create([
                    'nama_prodi' => "$jurusanName Prodi $i",
                    'jurusan_id' => $jurusan->id
                ]);

                for ($j = 1; $j <= 3; $j++) {
                    // Create Kelas
                    Kelas::create([
                        'nama_kelas' => "Kelas $j $prodi->nama_prodi",
                        'prodi_id' => $prodi->id
                    ]);
                }
            }
        }
    }
}
