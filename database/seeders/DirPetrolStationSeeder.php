<?php

namespace Database\Seeders;

use Database\Factories\DirPetrolStationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirPetrolStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'Газпромнефть',
            ]);
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'СургутНефтеГаз',
            ]);
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'Татнефть',
            ]);
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'Лукойл',
            ]);
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'Роснефть',
            ]);
        DirPetrolStationFactory::new()
            ->create([
                'title' => 'Нефтика',
            ]);
    }
}
