<?php

namespace Database\Seeders;

use App\Models\Balita;
use App\Models\Pengukuran;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BalitaPengukuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan ada minimal 1 user yang akan menjadi pengukur
        $user = User::first();

        if (! $user) {
            $user = User::create([
                'nama'     => 'Admin Posyandu',
                'username' => 'admin',
                'email'    => 'admin@example.com',
                'password' => Hash::make('password'), // ganti nanti
                'role'     => 'admin',
            ]);
        }

        // Buat 20 balita
        for ($i = 0; $i < 20; $i++) {

            // Tanggal lahir antara 1 – 5 tahun lalu
            $tanggalLahir = Carbon::instance(
                $faker->dateTimeBetween('-5 years', '-1 year')
            )->startOfDay();

            $balita = Balita::create([
                'nama'          => $faker->firstName,
                'tanggal_lahir' => $tanggalLahir->toDateString(),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'nama_ibu'      => $faker->name('female'),
            ]);

            // 3 kali pengukuran per balita
            for ($j = 0; $j < 3; $j++) {

                // Tanggal ukur: beberapa bulan setelah lahir
                $tanggalUkur = (clone $tanggalLahir)->addMonths(12 + $j * 3 + rand(0, 2));

                // Jangan lewat hari ini
                if ($tanggalUkur->greaterThan(now())) {
                    $tanggalUkur = now()->subDays(rand(0, 30));
                }

                $umurBulan = $tanggalLahir->diffInMonths($tanggalUkur);

                // Perkiraan kasar antropometri (bukan standar WHO, hanya dummy)
                $tb = $faker->numberBetween(60, 110);          // tinggi cm
                $bb = round($tb / 10 + rand(0, 5), 1);         // berat kg kira-kira
                $lila = $faker->randomFloat(1, 10, 20);        // cm

                Pengukuran::create([
                    'id_balita'      => $balita->id_balita,
                    'id_user'        => $user->id,
                    'tanggal_ukur'   => $tanggalUkur->toDateString(),
                    'umur_bulan'     => $umurBulan,
                    'bb_kg'          => $bb,
                    'tb_cm'          => $tb,
                    'lila_cm'        => $lila,
                    'status_stunting' => $faker->boolean(20), // 20% kemungkinan stunting
                ]);
            }
        }
    }
}
