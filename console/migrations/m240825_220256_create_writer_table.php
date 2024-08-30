<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%writer}}`.
 */
class m240825_220256_create_writer_table extends Migration
{
    private string $tableName = '{{%writer}}';

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
            'lastname' => $this->string(100)->notNull(),
            'firstname' => $this->string(100)->notNull(),
            'patronymic' => $this->string(100),
        ], $tableOptions);

        $this->createIndex('idx_writer_fio', $this->tableName, ['lastname', 'firstname', 'patronymic'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
