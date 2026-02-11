<?php

namespace App\Contracts\Interface;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface WishlistInterface
{
    /**
     * Get all wishlists for a user
     */
    public function getByUser(User $user): Collection;

    /**
     * Add a book to user's wishlist
     */
    public function add(User $user, Book $book): bool;

    /**
     * Remove a book from user's wishlist
     */
    public function remove(User $user, Book $book): bool;

    /**
     * Check if a book exists in user's wishlist
     */
    public function exists(User $user, Book $book): bool;

    /**
     * Toggle wishlist (add if not exists, remove if exists)
     */
    public function toggle(User $user, Book $book): string;
}