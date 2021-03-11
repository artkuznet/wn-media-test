<?php

declare(strict_types=1);

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Dingo\Api\Http\Request;

class AuthorController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     */
    public function addAuthor(Request $request): array
    {
        $request->validate([
            'name' => 'string',
        ]);
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $author = new Author([
            'name' => $data['name'],
        ]);
        $author->save();

        return ['success' => true, 'id' => $author->id];
    }

    /**
     * @param int $id
     * @return Author
     * @throws \Exception
     */
    public function getAuthor(int $id): Author
    {
        /** @var Author $author */
        $author = Author::whereId($id)->with('books')->first();
        if (!$author) {
            throw new \Exception("Author with id $id not found");
        }

        return $author;
    }
}