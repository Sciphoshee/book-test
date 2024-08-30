<?php

namespace entities\Book;

class Writer
{

    public function __construct(
        private string $lastname,
        private string $firstname,
        private string $patronymic,
        private ?int $id = null
    )
    {

    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

}