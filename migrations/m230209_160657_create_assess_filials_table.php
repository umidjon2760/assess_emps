<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_filials}}`.
 */
class m230209_160657_create_assess_filials_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_filials', [
            'ID' => $this->primaryKey(),
            'MFO' => $this->string(10),
            'LOCAL_CODE' => $this->string(10),
            'NAME' => $this->string(150)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_filials');
    }
}
