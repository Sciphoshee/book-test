<?php

namespace common\models;

use entities\Book\Book as BookEntity;
use services\dto\BookDto;
use services\dto\BookImageDto;
use services\dto\WriterDto;

/**
 * @property File $image
 * @property Writer[] $writers
 */

class BookExtended extends Book
{
    public function getDto(): BookDto
    {
        $dto = new BookDto();
        $dto->id = $this->id;
        $dto->name = $this->name;
        $dto->releaseYear = $this->release_year;
        $dto->isbn = $this->isbn;
        $dto->description = $this->description;
        $dto->image = null; //todo
        $dto->writers = $this->getWritersDto();

        return $dto;
    }

    //Это пока плохо
    public static function getInstanceFromEntity(BookEntity $bookEntity): self
    {
        $book = new self();

        $book->setAttribute('id', (int)$bookEntity->getId()->getId());

        $book->setAttributes([
            'name' => $bookEntity->getName(),
            'release_year' => $bookEntity->getReleaseYear(),
            'isbn' => $bookEntity->getIsbn(),
            'description' => $bookEntity->getDescription(),
            'image_id' => null, //todo
            'writers' => [], //todo
        ]);

        return $book;
    }

    private function getImageDto(): ?BookImageDto
    {
        if ($this->image) {
            $dto = new BookImageDto();
        }

        return $dto ?? null;
    }

    private function getWritersDto(): ?array
    {
        $writersDto = [];
        foreach ($this->writers as $writer) {
            $writersDto[] = $writer->getDto();
        }
//        if ($this->writers) {
//        }

        return $writersDto;
    }

    private function getWriterDto(Writer $writer): ?WriterDto
    {
        return new WriterDto($writer->lastname, $writer->firstname, $writer->patronymic);
    }
}