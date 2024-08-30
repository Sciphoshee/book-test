<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 * @property string $name
 * @property int|null $release_year
 * @property int|null $image_id
 * @property string $isbn
 * @property string|null $description
 *
 * @property BookWriter[] $bookWriters
 * @property File $image
 * @property Writer[] $writers
 */
class Book extends \yii\db\ActiveRecord
{
                                    
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return [
            'timestamp' => \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status', 'release_year', 'image_id'], 'integer'],
            [['name', 'isbn'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['name'], 'unique'],
            [['isbn'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'name' => 'Name',
            'release_year' => 'Release Year',
            'image_id' => 'Image ID',
            'isbn' => 'Isbn',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[BookWriters]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\BookWriterQuery
     */
    public function getBookWriters()
    {
        return $this->hasMany(BookWriter::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\FileQuery
     */
    public function getImage()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }

    /**
     * Gets query for [[Writers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\WriterQuery
     */
    public function getWriters()
    {
        return $this->hasMany(Writer::class, ['id' => 'writer_id'])->viaTable('book_writer', ['book_id' => 'id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\BookQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\BookQuery(get_called_class());
    }
}
