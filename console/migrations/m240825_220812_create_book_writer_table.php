<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_writer}}`.
 */
class m240825_220812_create_book_writer_table extends Migration
{
    private string $tableName = '{{%book_writer}}';
    private string $tableNameBook = '{{%book}}';
    private string $tableNameWriter = '{{%writer}}';

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
            'book_id' => $this->integer()->notNull(),
            'writer_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_book_id', $this->tableName, 'book_id', $this->tableNameBook, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_writer_id', $this->tableName, 'writer_id', $this->tableNameWriter, 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_book_writer', $this->tableName, ['book_id', 'writer_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
