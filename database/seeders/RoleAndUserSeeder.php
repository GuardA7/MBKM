<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    public function run()
    {
        // Pastikan roles sudah ada
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $dosenRole = Role::where('name', 'dosen')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $masyarakatRole = Role::where('name', 'masyarakat')->first();

        // Generate 5 Mahasiswa untuk setiap Kelas
        $kelasList = Kelas::where('id', '>=', 4)->get(); // Mulai dari ID kelas 4
        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 5; $i++) { // Membatasi hanya 5 mahasiswa per kelas
                $uniqueEmail = "mahasiswa{$i}_kelas{$kelas->id}_" . uniqid() . "@example.com"; // Unik dengan uniqid
                $mahasiswa = User::create([
                    'nama' => "Mahasiswa {$i} {$kelas->nama_kelas}",
                    'email' => $uniqueEmail,
                    'password' => bcrypt('password'),
                    'role' => 'mahasiswa',
                    'nim' => str_pad($i . $kelas->id, 10, '0', STR_PAD_LEFT),
                    'no_hp' => '081234567' . rand(10, 99),
                    'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                    'prodi_id' => $kelas->prodi_id,
                    'kelas_id' => $kelas->id
                ]);
                $mahasiswa->assignRole($mahasiswaRole);
            }
        }

        // Generate 5 Dosen untuk setiap Jurusan
        $jurusanList = Jurusan::where('id', '>=', 5)->get(); // Mulai dari ID jurusan 5
        foreach ($jurusanList as $jurusan) {
            for ($i = 1; $i <= 5; $i++) { // Membatasi hanya 5 dosen per jurusan
                $uniqueEmail = "dosen{$i}_jurusan{$jurusan->id}_" . uniqid() . "@example.com"; // Unik dengan uniqid
                $dosen = User::create([
                    'nama' => "Dosen {$i} {$jurusan->nama_jurusan}",
                    'email' => $uniqueEmail,
                    'password' => bcrypt('password'),
                    'role' => 'dosen',
                    'nidn' => str_pad($i . $jurusan->id, 9, '0', STR_PAD_LEFT),
                    'no_hp' => '081234567' . rand(10, 99),
                    'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                    'prodi_id' => null // Dosen tidak selalu terikat ke Prodi
                ]);
                $dosen->assignRole($dosenRole);
            }
        }


        // Generate 5 Masyarakat Umum
        for ($i = 1; $i <= 5; $i++) { // Membatasi hanya 5 masyarakat
            $uniqueEmail = "masyarakat{$i}_" . uniqid() . "@example.com"; // Unik dengan uniqid
            $masyarakat = User::create([
                'nama' => "Masyarakat Umum {$i}",
                'email' => $uniqueEmail,
                'password' => bcrypt('password'),
                'role' => 'masyarakat',
                'nik' => str_pad($i, 16, '0', STR_PAD_LEFT),
                'no_hp' => '081345678' . rand(10, 99),
                'jenis_kelamin' => rand(0, 1) ? 'L' : 'P'
            ]);
            $masyarakat->assignRole($masyarakatRole);
        }
    }
}
