<?php

namespace app\modules\baholash\models;

use Yii;
use app\modules\baholash\models\Relation;
/**
 * This is the model class for table "assess_rel_pokaz".
 *
 * @property int $ID
 * @property int|null $REL_ID
 * @property string|null $POKAZ_CODE
 */
class RelPokaz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_rel_pokaz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['REL_ID'], 'integer'],
            [['POKAZ_CODE'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'REL_ID' => 'Богланиш ID',
            'POKAZ_CODE' => 'Показ',
        ];
    }

    public function getRelid()
    {
        return $this->hasOne(Relation::className(), ['ID' => 'REL_ID']);
    }

    public function getPokaz()
    {
        return $this->hasOne(Pokaz::className(), ['CODE' => 'POKAZ_CODE']);
    }

    
}
