<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_access_matrix}}`.
 */
class m230209_155204_create_assess_access_matrix_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_access_matrix', [
            'ID' => $this->primaryKey(),
            'TYPE' => $this->string(30)->notNull(),
            'VALUE' => $this->string(30)->notNull(),
            'MODUL' => $this->string(30)->notNull(),
            'IS_EXCEPTION' => $this->integer()->notNull()->defaultValue(0),
            'START_DATE' => $this->date()->notNull(),
            'END_DATE' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_access_matrix');
    }
}
