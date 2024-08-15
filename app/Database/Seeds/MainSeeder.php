<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('AgamaSeeder');
        $this->call('BeritaSeeder');
        $this->call('DataDusunSeeder');
        $this->call('DokumenPublikSeeder');
        $this->call('DusunSeeder');
        $this->call('GeografisSeeder');
        $this->call('JenisKelaminSeeder');
        $this->call('KategoriSeeder');
        $this->call('KepalaDusunSeeder');
        $this->call('KomentarBalasanBeritaSeeder');
        $this->call('KomentarBalasanPariwisataSeeder');
        $this->call('KomentarBalasanUMKMSeeder');
        $this->call('KomentarBeritaSeeder');
        $this->call('KomentarPariwisataSeeder');
        $this->call('KomentarUMKMSeeder');
        $this->call('KontakSeeder');
        $this->call('LayananSeeder');
        $this->call('PariwisataSeeder');
        $this->call('PekerjaanSeeder');
        $this->call('PengumumanSeeder');
        $this->call('PerangkatDesaSeeder');
        $this->call('SaranaPrasaranaSeeder');
        $this->call('SitusSeeder');
        $this->call('SliderSeeder');
        $this->call('StrukturOrganisasiSeeder');
        $this->call('TentangDesaSeeder');
        $this->call('UMKMSeeder');
        $this->call('UsiaSeeder');
        $this->call('VideoSeeder');
    }
}
