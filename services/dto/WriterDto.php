<?php

namespace services\dto;

class WriterDto
{

    public function __construct(
        public string $lastname,
        public string $firstname,
        public string $patronymic,
        public ?int $id = null
    )
    {
    }
}