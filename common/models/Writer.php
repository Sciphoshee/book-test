<?php

namespace common\models;

use entities\Book\Writer as WriterEntity;
use services\dto\WriterDto;

class Writer extends generated\models\Writer
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Добавлено',
            'updated_at' => 'Изменено',
            'lastname' => 'Фамилия',
            'firstname' => 'Имя',
            'patronymic' => 'Отчество',
        ];
    }

    /**
     * Gets query for [[BookWriters]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\BookWriterQuery
     */
    public function getBookWriters()
    {
        return $this->hasMany(BookWriter::class, ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\BookQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('book_writer', ['writer_id' => 'id']);
    }

    public function getShortName(): string
    {
        $firstnameLetter = mb_substr($this->firstname, 0, 1);
        $patronymicLetter = $this->patronymic ? mb_substr($this->patronymic, 0, 1) : '';

        return "{$this->lastname} {$firstnameLetter}." . ($patronymicLetter ? " {$patronymicLetter}." : '');
    }
}