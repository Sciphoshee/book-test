<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "writer_subscribe".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $writer_id
 * @property int $subscriber_id
 *
 * @property Subscriber $subscriber
 * @property Writer $writer
 */
class WriterSubscribe extends \yii\db\ActiveRecord
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
        return 'writer_subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'writer_id', 'subscriber_id'], 'integer'],
            [['writer_id', 'subscriber_id'], 'required'],
            [['writer_id', 'subscriber_id'], 'unique', 'targetAttribute' => ['writer_id', 'subscriber_id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::class, 'targetAttribute' => ['subscriber_id' => 'id']],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'writer_id' => 'Writer ID',
            'subscriber_id' => 'Subscriber ID',
        ];
    }

    /**
     * Gets query for [[Subscriber]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\SubscriberQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(Subscriber::class, ['id' => 'subscriber_id']);
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
    * @return \common\models\query\WriterSubscribeQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\WriterSubscribeQuery(get_called_class());
    }
}
