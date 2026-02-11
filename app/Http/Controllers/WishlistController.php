<?php
namespace App\Http\Controllers;

use App\Contracts\Interface\WishlistInterface;
use App\Models\Book;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistInterface $wishlistRepo
    ) {}

    public function index()
    {
        $wishlists = $this->wishlistRepo->getByUser(auth()->user());
        return view('wishlist.index', compact('wishlists'));
    }

   public function toggle(Book $book)
{
    \Log::info('Wishlist toggle called', [
        'book_id' => $book->id,
        'book_slug' => $book->slug,
        'user_id' => auth()->id()
    ]);

    $user = auth()->user();

    if ($this->wishlistRepo->exists($user, $book)) {
        $this->wishlistRepo->remove($user, $book);
        \Log::info('Wishlist removed successfully');
        return response()->json(['status' => 'removed', 'message' => 'Book removed from wishlist']);
    }

    $this->wishlistRepo->add($user, $book);
    \Log::info('Wishlist added successfully');
    return response()->json(['status' => 'added', 'message' => 'Book added to wishlist']);
}
}
