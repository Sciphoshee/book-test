<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "writer".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $lastname
 * @property string $firstname
 * @property string|null $patronymic
 *
 * @property BookWriter[] $bookWriters
 * @property Book[] $books
 * @property Subscriber[] $subscribers
 * @property WriterSubscribe[] $writerSubscribes
 */
class Writer extends \yii\db\ActiveRecord
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
        return 'writer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['lastname', 'firstname'], 'required'],
            [['lastname', 'firstname', 'patronymic'], 'string', 'max' => 100],
            [['lastname', 'firstname', 'patronymic'], 'unique', 'targetAttribute' => ['lastname', 'firstname', 'patronymic']],
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
            'lastname' => 'Lastname',
            'firstname' => 'Firstname',
            'patronymic' => 'Patronymic',
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

    /**
     * Gets query for [[Subscribers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\SubscriberQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(Subscriber::class, ['id' => 'subscriber_id'])->viaTable('writer_subscribe', ['writer_id' => 'id']);
    }

    /**
     * Gets query for [[WriterSubscribes]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\WriterSubscribeQuery
     */
    public function getWriterSubscribes()
    {
        return $this->hasMany(WriterSubscribe::class, ['writer_id' => 'id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\WriterQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\WriterQuery(get_called_class());
    }
}
