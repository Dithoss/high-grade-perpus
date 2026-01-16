<?php
namespace App\Http\Handlers;
use App\Contracts\Interface\BookInterface;
use App\Helpers\UploadHelper;
use App\Models\Book;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
class BookHandler
{
    public function __construct(
        protected BookInterface $repo,
    ) {}

    public function create(array $data): book
    {
        if (isset($data['image']) && $data['image']) {
            $imagePath = UploadHelper::uploadImage($data['image'], 'book');
            $data['image'] = $imagePath;
        }

        $user = $this->repo->store($data);


        return $user;
    }

    public function update(string $id, array $data): Book
    {
       DB::beginTransaction();
        try {
            $book = $this->repo->findById($id);

            if (isset($data['image']) && $data['image']) {
                if ($book->image) {
                    UploadHelper::deleteFile($book->image);
                }
                $imagePath = UploadHelper::uploadImage($data['image'], 'book');
                $data['image'] = $imagePath;
            }

            $updatedbook = $this->repo->update($id, $data);

            DB::commit();
            return $updatedbook;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}

