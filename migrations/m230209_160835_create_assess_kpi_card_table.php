<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assess_kpi_card}}`.
 */
class m230209_160835_create_assess_kpi_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('assess_kpi_card', [
            'ID' => $this->primaryKey(),
            'PERIOD' => $this->date(),
            'INPS' => $this->string(20),
            'MFO' => $this->string(10),
            'LOCAL_CODE' => $this->string(10),
            'CODE_DOLJ' => $this->string(10),
            'KPI_METHOD' => $this->string(20),
            'TABNUM' => $this->string(10),
            'ORD' => $this->integer(),
            'CRITERIY_NAME' => $this->integer(255),
            'CRITERIY_ALGORITHM' => $this->text(),
            'MIN_VALUE' => $this->float(),
            'AVG_VALUE' => $this->float(),
            'MAX_VALUE' => $this->float(),
            'VES' => $this->float(),
            'PLAN' => $this->float(),
            'FACT' => $this->float(),
            'BAJARILISH' => $this->float(),
            'IVSH' => $this->float(),
            'CRITERIY_KPI' => $this->float()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('assess_kpi_card');
    }
}
