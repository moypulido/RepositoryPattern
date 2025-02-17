<?php

namespace App\Repositories;

use App\Interfaces\BooksRepositoryInterface;
use App\Models\Books;
use Illuminate\Support\Facades\Log;

class BooksRepository implements BooksRepositoryInterface
{

    public function getAll()
    {
        return Books::all();
    }

    public function getById(int $id)
    {
        return Books::findOrFail($id);
    }

    public function store(array $data)
    {
        return Books::create($data);
    }

    public function update(array $data, int $id)
    {
        $book = Books::findOrFail($id);
        $book->update($data);
        return $book;
    }

    public function delete(int $id)
    {
        return Books::destroy($id);
    }
}
