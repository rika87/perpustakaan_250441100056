<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    protected $model = Buku::class;

    public function definition(): array
    {
        return [
            'kategori_id' => Kategori::inRandomOrder()->first()->id,
            'judul' => fake()->sentence(3),
            'penulis' => fake()->name(),
            'tahun_terbit' => fake()->numberBetween(2020, 2025),
        ];
    }
}