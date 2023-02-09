<?php

namespace app\modules\baholash\models;

use Yii;

/**
 * This is the model class for table "assess_relation".
 *
 * @property int $ID
 * @property string|null $GROUP_CODE
 * @property string|null $NUV_DOLJ_CODE
 * @property string|null $LOV_DOLJ_CODE1
 * @property string|null $LOV_DOLJ_CODE2
 * @property string|null $LOV_DOLJ_CODE3
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GROUP_CODE','POKAZ'], 'string', 'max' => 50],
            [['NUV_DOLJ_CODE', 'LOV_DOLJ_CODE1', 'LOV_DOLJ_CODE2', 'LOV_DOLJ_CODE3'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'GROUP_CODE' => 'Гурух коди',
            'NUV_DOLJ_CODE' => 'Бахоланувчи',
            'LOV_DOLJ_CODE1' => 'Бахоловчи1',
            'LOV_DOLJ_CODE2' => 'Бахоловчи2',
            'LOV_DOLJ_CODE3' => 'Бахоловчи3',
            'POKAZ' => 'Показ',
        ];
    }
    public static function getAllRelationID(){
        $model = self::find()->orderBy(['ID'=>SORT_ASC])->all();
        $arr = [];
        foreach ($model as $rel) {
            $arr[$rel->ID] = $rel->GROUP_CODE.' - '.$rel->NUV_DOLJ_CODE.' - '.$rel->LOV_DOLJ_CODE1.' - '.$rel->LOV_DOLJ_CODE2.' - '.$rel->LOV_DOLJ_CODE3;
        }
        return $arr;
    }
}
