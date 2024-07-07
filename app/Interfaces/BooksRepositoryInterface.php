<?php

namespace App\Interfaces;

interface BooksRepositoryInterface
{
    public function getAll();
    public function getById(int $id);
    public function store(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
}
