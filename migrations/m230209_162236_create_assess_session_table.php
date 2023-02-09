<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_session}}`.
 */
class m230209_162236_create_assess_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_session', [
            'ID' => $this->primaryKey(),
            'GROUP_CODE' => $this->string(50),
            'MFO' => $this->string(6)->comment('as local_code'),
            'LOV_ID' => $this->string(20),
            'SESSION_ID' => $this->integer(),
            'PERIOD' => $this->date(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_session');
    }
}
