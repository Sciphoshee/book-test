<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $name
 * @property string $original_name
 *
 * @property Book[] $books
 */
class File extends \yii\db\ActiveRecord
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
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'original_name'], 'required'],
            [['name', 'original_name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'name' => 'Name',
            'original_name' => 'Original Name',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\BookQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['image_id' => 'id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\FileQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\FileQuery(get_called_class());
    }
}
