<?php

namespace app\modules\baholash\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\baholash\models\Zagr;
/**
 * This is the model class for table "assess_filials".
 *
 * @property int $ID
 * @property string|null $MFO
 * @property string|null $LOCAL_CODE
 * @property string|null $NAME
 */
class Filials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_filials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MFO', 'LOCAL_CODE'], 'string', 'max' => 10],
            [['NAME'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MFO' => 'МФО',
            'LOCAL_CODE' => 'Локал код',
            'NAME' => 'Номи',
        ];
    }

    public static function getAll()
    {
        $model = self::find()->orderBy(['NAME'=>SORT_ASC])->all();
        $items = ArrayHelper::map($model,'LOCAL_CODE','NAME');
        return $items;
    }

    public static function getLocal($mfo)
    {
        $model = self::find()->where(['MFO'=>$mfo])->one();
        if ($model) {
            return $model->LOCAL_CODE;
        }
        else{
            return '9999999';
        }
    }

    public static function getName($local)
    {
        $model = self::find()->where(['like','LOCAL_CODE',$local])->one();
        if ($model) {
            return $model->NAME;
        }
        else{
            return 'no filial';
        }
    }
    
}
