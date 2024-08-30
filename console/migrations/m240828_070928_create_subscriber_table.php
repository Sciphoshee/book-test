<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber}}`.
 */
class m240828_070928_create_subscriber_table extends Migration
{
    private $tableName = '{{%subscriber}}';
    private $tableNameUser = '{{%user}}';

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
            'user_id' => $this->integer()->unique(),
            'phone' => $this->string(18)->unique(),
            'email' => $this->string()->unique(),
        ], $tableOptions);

        $this->createIndex('idx_user_id_phone', $this->tableName, ['user_id', 'phone'], true);
        $this->createIndex('idx_user_id_email', $this->tableName, ['user_id', 'email'], true);
        $this->addForeignKey('fk_user_id', $this->tableName, 'user_id', $this->tableNameUser, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
