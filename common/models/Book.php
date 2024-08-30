<?php

namespace common\models;

/**
 * @property File $image
 * @property Writer[] $writers
 */

class Book extends generated\models\Book
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    const EVENT_PUBLISH = 'event_publish';

    public static $statuses = [
        self::STATUS_DRAFT => 'Черновик',
        self::STATUS_PUBLISHED => 'Опубликовано',
    ];

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'status' => 'Статус',
            'name' => 'Название',
            'release_year' => 'Дата публикации',
            'image_id' => 'Изображение',
            'isbn' => 'ISBN',
            'description' => 'Описание',
            'writers' => 'Авторы',
        ];
    }


    /**
     * Gets query for [[Writers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WriterQuery
     */
    public function getWriters()
    {
        return $this->hasMany(Writer::class, ['id' => 'writer_id'])->viaTable('book_writer', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\FileQuery
     */
    public function getImage()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }

    public function getStatusName(): string
    {
        return self::$statuses[$this->status];
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function publish(): bool
    {
        if ($this->canBePulished()) {
            $this->setStatusPublished();

            if ($this->save()) {
                $this->trigger(self::EVENT_PUBLISH);

                return true;
            }
        }

        return false;
    }

    /**
     * Проверка условий на доступность к публикации.
     *
     * Вообще этому в модели не место.
     *
     * @return bool
     */
    public function canBePulished(): bool
    {
        return $this->status === self::STATUS_DRAFT && $this->writers;
    }

    private function setStatusPublished(): void
    {
        $this->status = self::STATUS_PUBLISHED;
    }
}