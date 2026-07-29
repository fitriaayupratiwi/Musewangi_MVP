<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CollectionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'foto'=>null,
            'no_registrasi'=>fake()->unique()->numerify('REG-####'),
            'nama_koleksi'=>fake()->word(),
            'asal'=>'Banyuwangi',
            'kondisi'=>'Baik'
        ];

    }

}