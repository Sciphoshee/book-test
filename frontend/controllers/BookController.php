<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\Writer;
use Yii;
use yii\base\Event;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add', 'edit', 'update', 'delete', 'manage-writer'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Book::find(),
            ]),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                $this->redirect(['book/manage-writer', 'id' => $model->id]);
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                $this->redirect(['book/view', 'id' => $model->id]);
            }
        }

        return $this->render(Yii::$app->controller->action->id, [
            'model' => $model,
        ]);
    }

    public function actionManageWriter($id)
    {
        $model = $this->findModel($id);
        $writer = new Writer();

        if (Yii::$app->request->isPost) {
            if ($writer->load(Yii::$app->request->post())) {
                if ($writer->validate()) {
                    if ($writer->save()) {
                        $model->link('writers', $writer);
                        $this->redirect(['book/manage-writer', 'id' => $model->id]);
                    }
                }
            }

            if ($writerId = Yii::$app->request->post('remove_writer')) {
                $writer = $this->findWriterModel($writerId);
                if ($writer) {
                    $model->unlink('writers', $writer, true);
                    $this->redirect(['book/manage-writer', 'id' => $model->id]);
                }
            }

            if ($writerId = Yii::$app->request->post('add_writer')) {
                $writer = $this->findWriterModel($writerId);
                if ($writer) {
                    $model->link('writers', $writer);
                    $this->redirect(['book/manage-writer', 'id' => $model->id]);
                }
            }
        }

        $bookWritersDataProvider = new ActiveDataProvider([
            'query' => $model->getWriters(),
        ]);

        $writersDataProvider = new ActiveDataProvider([
            'query' => Writer::find(),
            'pagination' => false
        ]);

        return $this->render('manage-writer', [
            'model' => $model,
            'bookWritersDataProvider' => $bookWritersDataProvider,
            'writersDataProvider' => $writersDataProvider,
            'writer' => $writer,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model) {
            $model->delete();
        }

        $this->redirect(['book/index']);
        Yii::$app->end();
    }

    public function actionPublish($id)
    {
        $model = $this->findModel($id);

        if ($model->isPublished()) {
            Yii::$app->session->addFlash('success', 'Книга успешно опубликована.');
        } else {
            if ($model && $model->canBePulished()) {
                $published = $model->publish();

                if ($published) {
                    Yii::$app->session->addFlash('success', 'Книга успешно опубликована.');
                } else {
                    Yii::$app->session->setFlash('error', 'Что-то пошло не так, опубликовать не удалиось.');
                }
            } else {
                Yii::$app->session->setFlash('warning', 'Ошибка. Не все данные книги заполнены, не опубликовано.');
            }
        }

        $this->redirect(['book/view', 'id' => $model->id]);
    }

    private function findModel(int $id): ?Book
    {
        return Book::findOne($id) ?: null;
    }

    private function findWriterModel(int $id): ?Writer
    {
        return Writer::findOne($id) ?: null;
    }
}