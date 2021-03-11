<?php

declare(strict_types=1);

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BookController extends Controller
{
    /**
     * @return Collection
     */
    public function getBooks(): Collection
    {
        return Book::all();
    }

    /**
     * @param int $id
     * @return Book
     * @throws \Exception
     */
    public function getBook(int $id): Book
    {
        /** @var Book $book */
        $book = Book::whereId($id)->with('authors')->first();
        if (!$book) {
            throw new \Exception("Book with id $id not found");
        }

        return $book;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function editBook(int $id, Request $request): array
    {
        $request->validate([
            'name' => 'string',
            'authors' => 'array',
        ]);
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        /** @var Book $book */
        $book = Book::whereId($id)->first();
        if (!$book) {
            throw new \Exception("Book with id $id not found");
        }

        $authors_unique = $this->getAuthors($data);
        $book->name = $data['name'];
        $book->authors()->detach();
        $book->authors()->attach($authors_unique);
        $book->save();

        return ['success' => true];
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function addBook(Request $request): array
    {
        $request->validate([
            'name' => 'string',
            'authors' => 'array',
        ]);
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $authors_unique = $this->getAuthors($data);
        $book = new Book([
            'name' => $data['name'],
        ]);
        $book->save();
        $book->authors()->attach($authors_unique);

        return ['success' => true, 'id' => $book->id];
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    private function getAuthors(array $data): array
    {
        $authors_unique = array_unique($data['authors']);
        $authors = Author::whereIn('id', $authors_unique)->get();
        if (count($authors_unique) !== $authors->count()) {
            $diff = implode(', ', array_diff($authors_unique, $authors->pluck('id')->toArray()));
            throw new \Exception("Authors with ids $diff not found");
        }

        return $authors_unique;
    }
}