<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_slides}}`.
 */
class m230209_162456_create_assess_slides_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_slides', [
            'ID' => $this->primaryKey(),
            'URL' => $this->string(100),
            'NAME' => $this->string(255),
            'ORD ' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_slides');
    }
}
