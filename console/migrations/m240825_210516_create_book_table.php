<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m240825_210516_create_book_table extends Migration
{
    private string $tableName = '{{%book}}';
    private string $tableNameFile = '{{%file}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull()->unique(),
            'release_year' => $this->integer(4),
            'image_id' => $this->integer(),
            'isbn' => $this->string(13)->notNull()->unique(),
            'description' => $this->text(),
        ], $tableOptions);

        $this->createIndex('idx-release_year', $this->tableName, 'release_year');
        $this->addForeignKey('fk_image_id', $this->tableName, 'image_id', $this->tableNameFile, 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
