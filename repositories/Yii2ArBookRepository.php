<?php

namespace repositories;

use common\models\Book as BookModel;
use common\models\File;
use common\models\Writer as WriterModel;
use entities\Book\Book;
use entities\Book\Id;
use entities\Book\Image;
use entities\Book\Writer;
use services\dto\BookDto;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\log\Logger;
use yii\web\NotFoundHttpException;

class Yii2ArBookRepository implements BookRepositoryInterface
{

    public function getById(Id $id): Book
    {
        $book = BookModel::findOne($id->getId());
        if (!$book) {
            throw new NotFoundHttpException('The requested book does not exist.');
        }

        return $this->getBookEntityFromModel($book);
    }

    public function getAll(): array
    {
        $models = BookModel::find()->all();
        if ($models) {
            $entities = array_map(function (BookModel $book) {
                return $this->getBookEntityFromModel($book);
            }, $models);
        }

        return $entities ?? [];
    }

    public function delete($book): void
    {
        // TODO: Implement delete() method.
    }

    public function save(Book $book): int
    {
        //Транзакции
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

//        dumpVar($book);
//        die();

        try {
            $bookModel = $this->getBookModel($book);
            $oldWriters = $bookModel->getWriters()->indexBy('id')->all();
            $writersModels = $this->getWritersModels($book->getWriters());

            if ($writersModels) {
//                var_dump($writersModels);
                $this->saveWriters($writersModels);
            }

            if ($bookModel->save()) {
                //Приходит общий список авторов, как те что уже имеются в базе (с id>0), так и новые (с id<0)
                //Операция похоже разделяется на 2 части
                //- уже сохраненные писатели. Сравнить тех что были в книге с теми что остались, отвязать тех, которых больше нет и добавить те что новые
                //- еще не сохраненные писатели. Надо сохранить и связать с книгой

                $this->linkNewWriters($bookModel, $oldWriters, $writersModels);
                $this->unlinkUnusedWriters($bookModel, $oldWriters, $writersModels);

//                throw new \Exception('test');

                $transaction->commit();

                return $bookModel->id;
            }

            throw new \DomainException('Book save error 1.');
        } catch (\Exception $e) {
            $transaction->rollBack();

            dumpVar($e->getMessage());
        }

        throw new \DomainException('Book save error 2.');
    }

    private function saveWriters(array $writers): void
    {
        /** @var WriterModel $writer */
        foreach ($writers as $writer) {
            if ($writer->validate()) {
                if (!$writer->save()) {
                    throw new Exception('Writer save error.');
                }
            } else {
                throw new Exception('Writer validation error: ' . var_export($writer->getErrors(), true));
            }
        }
    }

    private function getBookModel(Book $book): BookModel
    {
        if ($bookId = $book->getId()->getId()) {
            $model = BookModel::findOne($bookId);
        } else {
            $model = new BookModel();
        }

        if (!$model) {
            throw new NotFoundHttpException('The requested book does not exist.');
        }

        $model->setAttributes([
            'name' => $book->getName(),
            'release_year' => $book->getReleaseYear(),
            'isbn' => $book->getIsbn(),
            'description' => $book->getDescription(),
        ]);

        return $model;
    }

    //todo Переделать на работу с коллекцией
    private function getWritersModels(array $writers): array
    {
        $writersModels = [];

        /** @var Writer  $writer */
        foreach ($writers as $writer) {
            $writersModels[] = $this->getWriterModel($writer);
        }

        return $writersModels;
    }

    private function getWriterModel(Writer $writer): WriterModel
    {
        $id = $writer->getId();

        if ($id > 0) {
            $model = WriterModel::findOne($id);
        } else {
            $model = new WriterModel();
        }

        if (!$model) {
            throw new NotFoundHttpException("The requested writer does not exist. [id: {$id}]");
        }

        $model->setAttributes([
            'lastname' => $writer->getLastName(),
            'firstname' => $writer->getFirstName(),
            'patronymic' => $writer->getPatronymic(),
        ]);

        return $model;
    }

    private function linkNewWriters(BookModel $bookModel, array $oldWriters, $newWriters): void
    {
        /** @var WriterModel $writerModel */
        foreach ($newWriters as $writerModel) {
            if ($writerModel->id > 0) {
                if (!isset($oldWriters[$writerModel->id])) {
                    $bookModel->link('writers', $writerModel);
                }
            } else {
                throw new NotFoundHttpException("The requested writer does not exist: [id = {$writerModel->id}]");
            }
        }
    }

    private function unlinkUnusedWriters(BookModel $bookModel, array $oldWriters, $newWriters): void
    {
        $newWritersIds = ArrayHelper::getColumn($newWriters, 'id');

        foreach ($oldWriters as $oldWriter) {
            if (!in_array($oldWriter->id, $newWritersIds)) {
                $bookModel->unlink('writers', $oldWriter, true);
            }
        }
    }

    public function getWritersAll(): array
    {
        $writersModels = WriterModel::find()->all();
        return $this->getWritersEntitiesFromModels($writersModels);
    }

    public function getBooksWithWriterId(int $id): array
    {
        // TODO: Implement getBooksWithWriterId() method.
    }

    public function getBooksCountWithWriterId(int $id): int
    {
        // TODO: Implement getBooksCountWithWriterId() method.
    }


    private function getBookEntityFromModel(BookModel $model): Book
    {
        $writes = $this->getWritersEntitiesFromModels($model->writers);
        $bookImage = $model->image ? $this->getImageEntityFromModel($model->image) : null;

        return new Book(
            new Id($model->id),
            $model->name,
            $model->release_year,
            $model->isbn,
            $model->description,
            $writes,
            $bookImage
        );
    }

    private function getWritersEntitiesFromModels(array $writers): array
    {
        $writersModels = [];

        /** @var WriterModel $writer */
        foreach ($writers as $writer) {
            $writersModels[] = $this->getWriterEntityFromModel($writer);
        }

        return $writersModels;
    }
    private function getWriterEntityFromModel(WriterModel $writer): Writer
    {
        return new Writer(
            $writer->lastname,
            $writer->firstname,
            $writer->patronymic,
            (int)$writer->id
        );
    }

    private function getImageEntityFromModel(File $image): Image
    {
        return new Image(
            $image->id,
            $image->name,
            $image->original_name
        );
    }
}