<?php

namespace app\modules\baholash\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "assess_pokaz".
 *
 * @property int $ID
 * @property string|null $CODE
 * @property string|null $NAME
 * @property int|null $MIN_VALUE
 * @property int|null $MAX_VALUE
 */
class Pokaz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_pokaz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MIN_VALUE', 'MAX_VALUE'], 'integer'],
            [['CODE'], 'string', 'max' => 50],
            [['NAME'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CODE' => 'Код',
            'NAME' => 'Номи',
            'MIN_VALUE' => 'Минимум',
            'MAX_VALUE' => 'Максимум',
        ];
    }

    public static function getMaxMinValue($pokaz,$max_min)
    {
        $model = self::find()->where(['CODE'=>$pokaz])->one();
        if ($model) {
            if ($max_min=='max') {
                return $model->MAX_VALUE;
            }
            else{
                return $model->MIN_VALUE;
            }
        }
        else{
            return 0;
        }
    }

    public static function getAll()
    {
        $model = self::find()->all();
        $all = ArrayHelper::map($model,'CODE','NAME');
        return $all;
    }

    public static function getAllCode()
    {
        $model = self::find()->all();
        $all = ArrayHelper::map($model,'CODE','CODE');
        return $all;
    }

    public static function getAllWithPokaz(){
        $model = self::find()->all();
        $arr = [];
        foreach ($model as $rel) {
            $arr[$rel->CODE] = $rel->CODE.' - '.$rel->NAME;
        }
        return $arr;
    }
}
