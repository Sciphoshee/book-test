<?php

namespace common\models\query;

class SubscriberQuery extends \common\models\generated\query\SubscriberQuery
{
    public function byPhone($phone): SubscriberQuery
    {
        return $this->andWhere(['phone' => $phone]);
    }

    public function byEmail($email): SubscriberQuery
    {
        return $this->andWhere(['email' => $email]);
    }

    public function byUserId(int $id): SubscriberQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }
}