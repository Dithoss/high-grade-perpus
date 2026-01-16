<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Str;

class BookObserver
{
    public function generateUniqueSlug(Book $Book): string
    {
        $slug = Str::slug($Book->name);
        $slug .= '-' . date('YmdHis');
        return $slug;
    }
    public function creating(Book $Book)
    {
        if (empty($Book->slug)) {
            $Book->slug = $this->generateUniqueSlug($Book);
        }
        if (empty($Book->barcode)){
            $Book->barcode = $this->generateBarcode($Book);
        }
    }

    public function updating(Book $Book)
    {
        if ($Book->isDirty('name') || empty($Book->slug)) {
            $Book->slug = $this->generateUniqueSlug($Book);
        }
    }
    protected function generateBarcode(): string
    {
        return 'BK-' . random_int(10000000, 99999999);
    }

}
