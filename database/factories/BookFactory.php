<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(3);
        
        // Generate a fake book cover image
        $imagePath = $this->generateBookCover();

        return [
            'id'          => (string) Str::uuid(),
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . Str::random(6),
            'writer'      => $this->faker->name(),
            'stock'       => $this->faker->numberBetween(1, 50),
            'image'       => $imagePath,
            'barcode'     => $this->faker->unique()->ean13(),
            'category_id' => Category::factory(),
        ];
    }

    /**
     * Generate a book cover image and save it to storage
     */
    private function generateBookCover(): ?string
    {
        try {
            // Create books directory if it doesn't exist
            if (!Storage::disk('public')->exists('books')) {
                Storage::disk('public')->makeDirectory('books');
            }

            // Generate random filename
            $filename = 'book_' . Str::random(20) . '.jpg';
            $path = 'books/' . $filename;

            // Download a placeholder image from picsum.photos
            $imageContent = @file_get_contents('https://picsum.photos/300/400');
            
            if ($imageContent !== false) {
                Storage::disk('public')->put($path, $imageContent);
                return $path;
            }

            return null;
        } catch (\Exception $e) {
            \Log::warning('Failed to generate book cover: ' . $e->getMessage());
            return null;
        }
    }
}