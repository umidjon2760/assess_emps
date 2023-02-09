<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_users}}`.
 */
class m230209_162850_create_assess_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_users', [
            'ID' => $this->primaryKey(),
            'LOGIN ' => $this->string(50)->unique(),
            'PASSWORD ' => $this->string(50),
            'MFO ' => $this->string(6),
            'LOCAL_CODE ' => $this->string(7),
            'NAME ' => $this->string(150),
            'BOLIM_CODE ' => $this->string(10),
            'BOLIM_NAME ' => $this->string(150),
            'CODE_DOLJ ' => $this->string(20),
            'EMAIL ' => $this->string(150),
            'LAVOZIM_NAME ' => $this->string(150),
            'RASM ' => $this->string(255),
            'PHONE_NUMBER ' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_users');
    }
}
