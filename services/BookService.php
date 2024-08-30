<?php

namespace services;

use entities\Book\Book;
use entities\Book\Id;
use entities\Book\Writer;
use repositories\BookRepositoryInterface;
use services\dto\BookDto;
use services\dto\WriterDto;

class BookService
{
    private BookRepositoryInterface $repository;

    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(BookDto $dto): int
    {
        $book = $this->getBookEntityFromDto($dto);
        return $this->repository->save($book);
    }

    public function getById(Id $id): Book
    {
        return $this->repository->getById($id);
    }

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function getWritersAll(): array
    {
        $writers = $this->repository->getWritersAll();

        return $writers;
    }

    public function getWriterBooks(Writer $writer): array
    {

    }

    private function getBookEntityFromDto(BookDto $dto): Book
    {
        $writers = [];
        if ($dto->writers) {
            /** @var WriterDto $writerDto */
            foreach ($dto->writers as $writerDto) {
                $writers[] = new Writer(
                    $writerDto->lastname,
                    $writerDto->firstname,
                    $writerDto->patronymic,
                    $writerDto->id
                );
            }
        }

        return new Book(
            new Id($dto->id),
            $dto->name,
            $dto->releaseYear,
            $dto->isbn,
            $dto->description,
            $writers,
            $dto->image
        );
    }
}