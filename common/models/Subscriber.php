<?php

namespace common\models;

use common\validators\PhoneValidator;

/**
 *
 * @property WriterSubscribe $writerSubscribe
 */

class Subscriber extends generated\models\Subscriber
{
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['phone'], PhoneValidator::class],
            [['email'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['user_id', 'phone'], 'unique', 'targetAttribute' => ['user_id', 'phone']],
            [['user_id', 'email'], 'unique', 'targetAttribute' => ['user_id', 'email']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function hasPhone(): bool
    {
        return !empty($this->phone);
    }

    /**
     * Gets query for [[WriterSubscribes]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\WriterSubscribeQuery|WriterSubscribe
     */
    public function getWriterSubscribe(Writer $writer)
    {
        return $this->hasMany(WriterSubscribe::class, ['writer_id' => 'id'])
            ->andWhere(['writer_id' => $writer->id]);
    }
}