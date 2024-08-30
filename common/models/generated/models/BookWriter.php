<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "book_writer".
 *
 * @property int $id
 * @property int $book_id
 * @property int $writer_id
 *
 * @property Book $book
 * @property Writer $writer
 */
class BookWriter extends \yii\db\ActiveRecord
{
            
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_writer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'writer_id'], 'required'],
            [['book_id', 'writer_id'], 'integer'],
            [['book_id', 'writer_id'], 'unique', 'targetAttribute' => ['book_id', 'writer_id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Writer::class, 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'writer_id' => 'Writer ID',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\BookQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[Writer]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\WriterQuery
     */
    public function getWriter()
    {
        return $this->hasOne(Writer::class, ['id' => 'writer_id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\BookWriterQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\BookWriterQuery(get_called_class());
    }
}
