<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\Writer;
use entities\Book\Id;
use services\BookService;
use services\dto\BookDto;
use services\dto\WriterDto;
use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BookExtController extends Controller
{
    private BookService $bookService;

    public function __construct($id, $module, BookService $bookService, $config = []){
        $this->bookService = $bookService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $entities = $this->bookService->getAll();

        $models = array_map(function ($entity) {
            return Book::getInstanceFromEntity($entity);
        }, $entities);

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $bookEntity = $this->bookService->getById(new Id($id));
        $model = (new Book())->getInstanceFromEntity($bookEntity);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        $model = new Book();
        $modelWriter = new Writer();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $writers = Yii::$app->request->post($modelWriter->formName(), []);
                $bookDto = $this->prepareBookDto($model, $writers);
                $bookId = $this->bookService->save($bookDto);

                $this->redirect(['book/view', 'id' => $bookId]);
            } catch (\Exception $e) {
//                var_dump($e->getMessage());
            }
        }

        return $this->render('add', [
            'model' => $model,
            'modelWriter' => $modelWriter,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $modelWriters = $model ? $model->writers : [];
        $modelWriter = new Writer();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            try {
                $writers = Yii::$app->request->post($modelWriter->formName(), []);
                $bookDto = $this->prepareBookDto($model, $writers);
                $bookId = $this->bookService->save($bookDto);

                $this->redirect(['book/view', 'id' => $bookId]);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }

        $bookEntity = $this->bookService->getById(new Id($id));
        $model = Book::getInstanceFromEntity($bookEntity);

        return $this->render(Yii::$app->controller->action->id, [
            'model' => $model,
            'modelWriter' => $modelWriter,
            'writers' => $modelWriters,
        ]);
    }

    private function prepareBookDto(Book $model, array $writers): BookDto
    {
        $bookDto = $model->getDto();

        $writers = array_map(function ($writer) {
            if ($writer['id'] > 0) {
                $writerModel = $this->findWriterModel($writer['id']);
            } else {
                $writerModel = new Writer();
            }

            $writerModel->load($writer, '');
            return $writerModel;
        }, $writers);

        $bookDto->writers = Writer::getMultipleDto($writers);

        return $bookDto;
    }

    private function findModel($id): ?Book
    {
        return Book::findOne($id) ?: null;
    }

    private function findWriterModel(int $id): ?Writer
    {
        return Writer::findOne($id) ?: null;
    }
}