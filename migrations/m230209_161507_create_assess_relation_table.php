<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_relation}}`.
 */
class m230209_161507_create_assess_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_relation', [
            'ID' => $this->primaryKey(),
            'GROUP_CODE' => $this->string(50),
            'NUV_DOLJ_CODE' => $this->string(20),
            'LOV_DOLJ_CODE1' => $this->string(20),
            'LOV_DOLJ_CODE2' => $this->string(20),
            'LOV_DOLJ_CODE3' => $this->string(20),
            'POKAZ' => $this->string(50)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_relation');
    }
}
