<?php

namespace app\modules\baholash\models;

use Yii;

/**
 * This is the model class for table "assess_period".
 *
 * @property int $ID
 * @property int|null $IS_OPEN
 * @property string|null $PERIOD
 */
class Period extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IS_OPEN'], 'integer'],
            [['PERIOD'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'IS_OPEN' => 'Очиқ',
            'PERIOD' => 'Период',
        ];
    }

    public static function getPeriod(){
        $model = self::find()->where(['IS_OPEN'=>1])->orderBy(['PERIOD'=>SORT_DESC])->one();
        if ($model) {
            return $model->PERIOD;
        }
        else{
            return '2000-01-01';
        }
    } 

    public static function getAllPeriods()
    {
        $model = self::find()->orderBy(['PERIOD'=>SORT_DESC])->all();
        $arr = [];
        foreach ($model as $key) {
            $arr[$key->PERIOD] = date('d.m.Y',strtotime($key->PERIOD));
        }
        return $arr;
    }
    public static function getMonthName($i){
        switch ($i) {
            case 1:
                return 'Январь';
                break;
            case 2:
                return 'Февраль';
                break;
            case 3:
                return 'Март';
                break;
            case 4:
                return 'Апрель';
                break;
            case 5:
                return 'Май';
                break;
            case 6:
                return 'Июнь';
                break;
            case 7:
                return 'Июль';
                break;
            case 8:
                return 'Август';
                break;
            case 9:
                return 'Сентябрь';
                break;
            case 10:
                return 'Октябрь';
                break;
            case 11:
                return 'Ноябрь';
                break;
            case 12:
                return 'Декабрь';
                break;
            default:
                return 'Ошибка';
                break;
        }
    }
    public static function getPeriodByOy($oy)
    {
        $active_period = self::getPeriod();
        $active_oy = date('m',strtotime($active_period));
        $active_yil = date('Y',strtotime($active_period));
        if($oy>$active_oy){
            $yil=$active_yil-1;
        }
        else{
            $yil = $active_yil;
        }
        if($oy<10){
            $oy='0'.$oy;
        }
        $period = '01.'.$oy.'.'.$yil;
        $period = date('Y-m-d',strtotime($period));
        return $period;
        // $query = "select * from assess_period where period='{$period}'";
        // $res = Yii::$app->db->createCommand($query)->queryAll();
        // if(isset($res[0]['DT'])){
        //     return $res[0]['DT'];
        // }
        // else{
        //     return 'notfound';
        // }

    }
    public static function getMaxPeriod()
    {
        $idcat = self::find()->max('PERIOD');
        return $idcat;
    }
}
