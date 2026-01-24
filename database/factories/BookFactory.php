<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(3);

        return [
            'id'          => (string) Str::uuid(),
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . Str::random(6),
            'writer'      => $this->faker->name(),
            'stock'       => $this->faker->numberBetween(1, 50),
            'image'       => null,
            'barcode'     => $this->faker->unique()->ean13(),
            'category_id' => Category::factory(),
        ];
    }
}
