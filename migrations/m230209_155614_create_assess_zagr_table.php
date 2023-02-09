<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_zagr}}`.
 */
class m230209_155614_create_assess_zagr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_zagr', [
            'ID' => $this->primaryKey(),
            'CBID' => $this->integer(),
            'INPS' => $this->string(20),
            'MFO' => $this->string(10),
            'LOCAL_CODE' => $this->string(10),
            'NAME' => $this->string(150),
            'BOLIM_CODE' => $this->string(10),
            'BOLIM_NAME' => $this->string(150),
            'CODE_DOLJ' => $this->string(10),
            'LAVOZIM_NAME' => $this->string(150),
            'NAME_NAPRAV' => $this->string(100),
            'TABEL' => $this->string(10),
            'PERIOD' => $this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_zagr');
    }
}
