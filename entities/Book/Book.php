<?php

namespace entities\Book;

class Book
{
    public function __construct(
        private Id $id,
        private string $name,
        private int $releaseYear,
        private string $isbn,
        private string $description = '',
        private array $writers = [],
        private ?Image $image = null
    )
    {

    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    public function getWriters(): array
    {
        return $this->writers;
    }


}