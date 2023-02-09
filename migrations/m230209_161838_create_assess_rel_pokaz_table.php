<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_rel_pokaz}}`.
 */
class m230209_161838_create_assess_rel_pokaz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_rel_pokaz', [
            'ID' => $this->primaryKey(),
            'REL_ID' => $this->integer(),
            'POKAZ_CODE' => $this->string(50)
        ]);
        $this->addForeignKey('relation_pokaz_fk','assess_relation','ID','assess_rel_pokaz','REL_ID');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_rel_pokaz');
    }
}
