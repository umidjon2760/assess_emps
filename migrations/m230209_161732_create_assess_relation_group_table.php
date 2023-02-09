<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_relation_group}}`.
 */
class m230209_161732_create_assess_relation_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_relation_group', [
            'ID' => $this->primaryKey(),
            'CODE' => $this->string(50),
            'NAME' => $this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_relation_group');
    }
}
