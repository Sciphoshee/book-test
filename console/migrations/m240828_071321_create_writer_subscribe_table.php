<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%writer_subscribe}}`.
 */
class m240828_071321_create_writer_subscribe_table extends Migration
{
    private string $tableName = '{{%writer_subscribe}}';
    private string $tableNameWriter = '{{%writer}}';
    private string $tableNameSubscriber = '{{%subscriber}}';

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
            'writer_id' => $this->integer()->notNull(),
            'subscriber_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_writer_subscriber', $this->tableName, ['writer_id', 'subscriber_id'], true);
        $this->addForeignKey('fk_writer_subscriber_writer_id', $this->tableName, 'writer_id', $this->tableNameWriter, 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_writer_subscriber_subscriber_id', $this->tableName, 'subscriber_id', $this->tableNameSubscriber, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
