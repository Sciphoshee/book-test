<?php

namespace common\models\form\WriterSubscribe;

use common\models\Subscriber;
use common\models\Writer;
use common\models\WriterSubscribe;
use Yii;
use yii\base\Model;
use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

abstract class WriterSubscribeForm extends Model implements WriterSubscribeFormInterface
{
    const SCENARIO_SUBSCRIBE = 'subscribe';
    const SCENARIO_UNSUBSCRIBE = 'unsubscribe';

    public $writerId;
    public $actionType = self::SCENARIO_SUBSCRIBE;

    protected $writer;

    /** @var Subscriber|null */
    private $subscriber;

    /** @var \common\models\WriterSubscribe */
    private $writerSubscribe;

    protected $contactFieldName;

    /**
     * @param $writer
     */
    public function __construct(Writer $writer, $config = [])
    {
        $this->writer = $writer;

        return parent::__construct($config);
    }

    /**
     * Получить сущность подписчика по контактному атрибуту.
     *
     * @return Subscriber|null
     */
    abstract public function getSubscriberByContactFieldName(): ?Subscriber;

    public function init()
    {
        if (!$this->contactFieldName) {
            throw new \LogicException('Contact field name is required.');
        }

        $this->scenario = self::SCENARIO_SUBSCRIBE;
        $this->actionType = self::SCENARIO_SUBSCRIBE;

        $this->writerId = $this->writer->id;

        $this->getSubscriber();

        if ($this->subscriber) {
            $this->actualizeContactFormFromSubscriber();

            $this->writerSubscribe = $this->subscriber->getWriterSubscribe($this->writer)->one();

            if ($this->writerSubscribe) {
                $this->scenario = self::SCENARIO_UNSUBSCRIBE;
                $this->actionType = self::SCENARIO_UNSUBSCRIBE;
            }
        }

        parent::init();
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['writerId', $this->contactFieldName, 'actionType'], 'required'],
            [['writerId'], 'integer'],
            [['writerId'], 'exist', 'skipOnError' => true, 'targetClass' => Writer::class, 'targetAttribute' => ['writerId' => 'id']],
            ['actionType', 'in', 'range' => [self::SCENARIO_SUBSCRIBE, self::SCENARIO_UNSUBSCRIBE]],
        ]);
    }

    public function scenarios(): array
    {
        return ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_SUBSCRIBE => ['actionType', 'writerId', $this->contactFieldName],
            self::SCENARIO_UNSUBSCRIBE => ['actionType', 'writerId'],
        ]);
    }

    /**
     * Получить поле для ввода контактных данных для формы подписки
     *
     * @param ActiveForm $form
     * @return ActiveField
     */
    public function renderSubscribeActiveFormField(ActiveForm $form): ActiveField
    {
        return $form->field($this, $this->contactFieldName)->textInput();
    }

    /**
     * Получить информацию о подписке для формы, где была подписка
     *
     * @return string
     */
    public function renderUnsubscribe(): string
    {
        if ($this->isSubscribed()) {
            $contactFieldLabel = $this->getAttributeLabel($this->contactFieldName);

            return "Подключены оповещения на " . mb_strtolower($contactFieldLabel)
                . ":<br>{$this->subscriber->{$this->contactFieldName}}";
        }

        return "";
    }

    public function isSubscribed(): bool
    {
        return !empty($this->writerSubscribe);
    }

    /**
     * Запустить процесс подписки / отписки
     *
     * @return bool
     */
    public function execute(): bool
    {
        return $this->actionType == self::SCENARIO_SUBSCRIBE ? $this->subscribe() : $this->unsubscribe();
    }

    public function getContactFieldName(): string
    {
        return $this->contactFieldName;
    }

    private function subscribe(): bool
    {
        if ($this->isSubscribed()) {
            return true;
        }

        if (!$this->isSubscribed()) {
//            dumpVar($this->{$this->contactFieldName});

            $subscriber = $this->getSubscriber();

            $writerSubscribe = $this->getWriterSubscribe();

            if ($subscriber && $writerSubscribe) {
                $this->switchActionType();

                Yii::$app->session->setFlash('success', "Вы успешно подписаны на оповещения о поступлении книг писателя.");

                return true;
            }
        }
    }

    private function unsubscribe(): bool
    {
        if (!$this->isSubscribed()) {
            return true;
        }

        if ($this->isSubscribed()) {
            if ($this->writerSubscribe) {
                if ($this->writerSubscribe->delete()) {
                    $this->writerSubscribe = null;

                    $this->switchActionType();

                    Yii::$app->session->setFlash('success', "Вы успешно отписаны от оповещения о поступлении книг писателя.");
                    return true;
                }
            }
        }

        return false;
    }

    private function switchActionType(): void
    {
        if ($this->actionType == self::SCENARIO_SUBSCRIBE) {
            $this->actionType = self::SCENARIO_UNSUBSCRIBE;
            $this->scenario = self::SCENARIO_UNSUBSCRIBE;
        } else {
            $this->actionType = self::SCENARIO_SUBSCRIBE;
            $this->scenario = self::SCENARIO_UNSUBSCRIBE;
        }
    }

    private function getSubscriber(): ?Subscriber
    {
        $userId = Yii::$app->user->getId();

        if ($this->subscriber) {
            $this->actualizeSubscriberFromContactForm();
            return $this->subscriber;
        }

        if ($userId) {
            $this->subscriber = Subscriber::find()->byUserId($userId)->one();
        }

        if (!$this->subscriber) {
            if ($subscriberId = Yii::$app->session->get('subscriber_id')) {
                $this->subscriber = Subscriber::findOne($subscriberId);
            }
        }

        if (!$this->subscriber && $this->{$this->contactFieldName}) {
            $this->subscriber = $this->getSubscriberByContactFieldName();

            if (!$this->subscriber) {
                $this->subscriber = new Subscriber();
                $this->subscriber->setAttributes([
                    $this->contactFieldName => $this->{$this->contactFieldName},
                ]);
            }
        }


        if (!$this->subscriber) {
            return null;
        }

        if (!$this->subscriber->{$this->contactFieldName} && $this->{$this->contactFieldName}) {
            $this->subscriber->{$this->contactFieldName} = $this->{$this->contactFieldName};
        }

        if ($userId) {
            if (!$this->subscriber->user_id) {
                $this->subscriber->user_id = $userId;
            } elseif ($this->subscriber->user_id != $userId) {
                throw new \Exception('Этот контакт уже значится за другим пользователем');
            }
        }

        if ($this->subscriber->validate()) {
            if ($this->subscriber->save()) {

                if (!$userId) {
                    \Yii::$app->session->set('subscriber_id', $this->subscriber->id);
                } elseif (Yii::$app->session->has('subscriber_id')) {
                    Yii::$app->session->remove('subscriber_id');
                }

                return $this->subscriber;
            }
        }

        return null;
    }

    /**
     * Актуализация контактов подписчика, пользователь может указать что-то новое
     *
     * @return void
     */
    private function actualizeSubscriberFromContactForm(): void
    {
        if (
            $this->subscriber
            && $this->{$this->contactFieldName}
            && $this->subscriber->{$this->contactFieldName} != $this->{$this->contactFieldName}
        ) {
            $this->subscriber->{$this->contactFieldName} = $this->{$this->contactFieldName};
            $this->subscriber->save($this->contactFieldName);
        }
    }

    /**
     * Актуализация контактов подписчика, пользователь может указать что-то новое
     *
     * @return void
     */
    private function actualizeContactFormFromSubscriber(): void
    {
        if (
            !$this->{$this->contactFieldName}
            && $this->subscriber
            && $this->subscriber->{$this->contactFieldName}
        ) {
            $this->{$this->contactFieldName} = $this->subscriber->{$this->contactFieldName};
        }
    }

    private function getWriterSubscribe(): ?WriterSubscribe
    {
        if (!$this->writerSubscribe) {
            $this->writerSubscribe = new WriterSubscribe();
            $this->writerSubscribe->setAttributes([
                'writer_id' => $this->writerId,
                'subscriber_id' => $this->subscriber->id,
            ]);
        }

        if ($this->writerSubscribe->validate()) {
            if ($this->writerSubscribe->save()) {
                return $this->writerSubscribe;
            } else {
//                dumpVar($this->writerSubscribe->getErrors());
            }
        } else {
//            dumpVar($this->writerSubscribe->getErrors());
        }

        return null;
    }
}