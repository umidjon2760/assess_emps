<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_pokaz}}`.
 */
class m230209_161343_create_assess_pokaz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_pokaz', [
            'ID' => $this->primaryKey(),
            'CODE' => $this->string(50),
            'NAME' => $this->string(255),
            'MIN_VALUE' => $this->integer(),
            'MAX_VALUE' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_pokaz');
    }
}
