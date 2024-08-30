<?php

namespace frontend\controllers;

use common\models\search\WritersTopSearch;
use Yii;
use yii\web\Controller;

class StatisticController extends Controller
{
    public function actionIndex()
    {
        $model = new WritersTopSearch();
        $params = Yii::$app->request->post();

//        $params[$model->formName()]['release_year'] = 2024;

        $dataProvider = $model->search($params);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }
}