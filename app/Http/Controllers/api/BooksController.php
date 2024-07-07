<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBooksRequest;
use App\Http\Requests\UpdateBooksRequest;
use App\Http\Resources\BooksResource;
use App\Interfaces\BooksRepositoryInterface;
use Illuminate\Support\Facades\DB;


class BooksController extends Controller
{
    private BooksRepositoryInterface $booksRepositoryInterface;

    public function __construct(BooksRepositoryInterface $booksRepositoryInterface)
    {
        $this->booksRepositoryInterface = $booksRepositoryInterface;
    }

    // GET /books
    public function index()
    {
        try {
            $data = $this->booksRepositoryInterface->getAll();
            return ApiResponseHelper::sendResponse(BooksResource::collection($data), '', 200);
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, 'Failed to retrieve all books', 500);
        }
    }

    // GET /books/{book}
    public function show(int $id)
    {
        try {
            $book = $this->booksRepositoryInterface->getById($id);
            if ($book) {
                return ApiResponseHelper::sendResponse(new BooksResource($book), 'Book retrieved successfully', 200);
            }
            return ApiResponseHelper::sendResponse(null, 'Book not found', 404);
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, 'Failed to retrieve book', 500);
        }
    }

    // POST /books
    public function store(StoreBooksRequest $request)
    {
        $data = [
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year
        ];

        DB::beginTransaction();
        try {
            $book = $this->booksRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseHelper::sendResponse(new BooksResource($book), 'Book created successfully', 201);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollBack($e, 'Failed to create book', 500);
        }
    }

    public function update(UpdateBooksRequest $request, int $id)
    {
        $data = $request->validate();
        DB::beginTransaction();
        try {
            $book = $this->booksRepositoryInterface->update($data, $id);
            DB::commit();
            if ($book) {
                return ApiResponseHelper::sendResponse(new BooksResource($book), 'Book updated successfully', 200);
            }
            return ApiResponseHelper::sendResponse(null, 'Book not found', 404);
        } catch (\Exception $e) {
            return ApiResponseHelper::rollBack($e, 'Failed to update book', 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $deleted = $this->booksRepositoryInterface->delete($id);
            if ($deleted) {
                return ApiResponseHelper::sendResponse(null, 'Book deleted successfully', 204);
            }
            return ApiResponseHelper::sendResponse(null, 'Book not found', 404);
        } catch (\Exception $e) {
            return ApiResponseHelper::throw($e, 'Failed to delete book', 500);
        }
    }
}