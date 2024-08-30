<?php

namespace entities\Book;

class Image
{

    public function __construct(
        private int $id,
        private string $name,
        private string $originalName,
    )
    {
    }
}