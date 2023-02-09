<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_fact}}`.
 */
class m230209_160148_create_assess_fact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_fact', [
            'ID' => $this->primaryKey(),
            'GROUP_CODE' => $this->string(50),
            'LOV_ID' => $this->string(20),
            'NUV_ID' => $this->string(20),
            'POKAZ_CODE' => $this->string(50),
            'VALUE' => $this->integer(),
            'COMMENT' => $this->string(255),
            'PERIOD' => $this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_fact');
    }
}
