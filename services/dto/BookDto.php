<?php

namespace services\dto;

class BookDto
{
    public int $createdAt;
    public int $updatedAt;
    public ?int $id = null;
    public string $name;
    public string $releaseYear;
    public string $description;
    public string $isbn;
    public array $writers = [];
    public ?BookImageDto $image = null;
}