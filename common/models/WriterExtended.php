<?php

namespace common\models;

use entities\Book\Writer as WriterEntity;
use services\dto\WriterDto;

class WriterExtended extends Writer
{
    public static function getInstanceFromEntity(WriterEntity $writerEntity): self
    {
        $book = new self();

        $book->setAttribute('id', (int)$writerEntity->getId());

        $book->setAttributes([
            'lastname' => $writerEntity->getLastname(),
            'firstname' => $writerEntity->getFirstname(),
            'patronymic' => $writerEntity->getPatronymic(),
        ]);

        return $book;
    }

    public function getDto(): ?WriterDto
    {
        return new WriterDto($this->lastname, $this->firstname, $this->patronymic, $this->id > 0 ? $this->id : null);
    }

    public static function getMultipleDto(array $writers): array
    {
        return array_map(function (self $writer) {
            return $writer->getDto();
        }, $writers);
    }
}