<?php

namespace repositories;

use entities\Book\Book;
use entities\Book\Id;
use entities\Book\Writer;

interface BookRepositoryInterface
{
    public function getById(Id $id): Book;

    public function getAll(): array;
    public function getWritersAll(): array;
    public function getBooksWithWriterId(int $id): array;
    public function getBooksCountWithWriterId(int $id): int;

    public function save(Book $book): int;

    public function delete($book): void;


}