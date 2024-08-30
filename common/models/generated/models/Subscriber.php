<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $user_id
 * @property string|null $phone
 * @property string|null $email
 *
 * @property User $user
 * @property WriterSubscribe[] $writerSubscribes
 * @property Writer[] $writers
 */
class Subscriber extends \yii\db\ActiveRecord
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
        return 'subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['phone'], 'string', 'max' => 18],
            [['email'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['user_id', 'phone'], 'unique', 'targetAttribute' => ['user_id', 'phone']],
            [['user_id', 'email'], 'unique', 'targetAttribute' => ['user_id', 'email']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'phone' => 'Phone',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[WriterSubscribes]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\WriterSubscribeQuery
     */
    public function getWriterSubscribes()
    {
        return $this->hasMany(WriterSubscribe::class, ['subscriber_id' => 'id']);
    }

    /**
     * Gets query for [[Writers]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\WriterQuery
     */
    public function getWriters()
    {
        return $this->hasMany(Writer::class, ['id' => 'writer_id'])->viaTable('writer_subscribe', ['subscriber_id' => 'id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\SubscriberQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\SubscriberQuery(get_called_class());
    }
}
