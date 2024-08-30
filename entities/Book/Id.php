<?php

namespace entities\Book;

class Id
{
    public function __construct(private ?string $id = null)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}