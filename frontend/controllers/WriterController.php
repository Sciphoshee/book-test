<?php

namespace frontend\controllers;

use common\fabric\WriterSubscribe\WriterSubscribeFabricInterface;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\Writer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WriterController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Writer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        //Абстрактная фабрика
        $fabric = Yii::createObject(WriterSubscribeFabricInterface::class);
        $writerSubscribeForm = $fabric->getWriterSubscribeForm($model);

        //Или просто через DIContainer
//        $writerSubscribeForm = Yii::createObject(WriterSubscribeFormInterface::class, [$model]);

        if ($writerSubscribeForm->load(Yii::$app->request->post())) {
            if ($writerSubscribeForm->validate()) {
                $writerSubscribeForm->execute();
            }
        }

        if ($model) {
            $booksDataProvider = new ActiveDataProvider([
                'query' => $model->getBooks(),
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
            'booksDataProvider' => $booksDataProvider,
            'subscribeForm' => $writerSubscribeForm,
        ]);
    }

    private function findModel(int $id): ?Writer
    {
        return Writer::findOne($id) ?: null;
    }
}