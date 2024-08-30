<?php

namespace common\models\generated\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $username
 * @property string $email
 * @property string|null $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int $status
 * @property string|null $verification_token
 *
 * @property Subscriber $subscriber
 */
class User extends \yii\db\ActiveRecord
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
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['username', 'email', 'auth_key', 'password_hash'], 'required'],
            [['username', 'email', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 18],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'username' => 'Username',
            'email' => 'Email',
            'phone' => 'Phone',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Subscriber]].
     *
     * @return \yii\db\ActiveQuery|\common\models\generated\query\SubscriberQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(Subscriber::class, ['user_id' => 'id']);
    }

    /**
    * @inheritdoc
    * @return \common\models\query\UserQuery the active query used by this AR class.
    */
    public static function find()
    {
    return new \common\models\query\UserQuery(get_called_class());
    }
}
