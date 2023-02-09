<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_period}}`.
 */
class m230209_161230_create_assess_period_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_period', [
            'ID' => $this->primaryKey(),
            'IS_OPEN' => $this->integer(),
            'PERIOD' => $this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_period');
    }
}
