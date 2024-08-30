<?php

namespace frontend\controllers;

use common\models\Writer AS WriterModel;
use services\BookService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class WriterControllerExt extends Controller
{
    private BookService $bookService;

    public function __construct($id, $module, BookService $bookService, $config = []){
        $this->bookService = $bookService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $entities = $this->bookService->getWritersAll();

        $models = array_map(function ($entity) {
            return WriterModel::getInstanceFromEntity($entity);
        }, $entities);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}