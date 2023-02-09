<?php

namespace app\modules\baholash\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\baholash\models\Period;
/**
 * This is the model class for table "assess_kpi_card".
 *
 * @property int $ID
 * @property string|null $PERIOD
 * @property string|null $INPS
 * @property string|null $MFO
 * @property string|null $LOCAL_CODE
 * @property string|null $CODE_DOLJ
 * @property string|null $KPI_METHOD
 * @property string|null $TABNUM
 * @property int|null $ORD
 * @property string|null $CRITERIY_NAME
 * @property string|null $CRITERIY_ALGORITHM
 * @property float|null $MIN_VALUE
 * @property float|null $AVG_VALUE
 * @property float|null $MAX_VALUE
 * @property float|null $VES
 * @property int|null $PLAN
 * @property int|null $FACT
 * @property float|null $BAJARILISH
 * @property float|null $IVSH
 * @property float|null $CRITERIY_KPI
 */
class KpiCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_kpi_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PERIOD'], 'safe'],
            [['ORD', 'PLAN', 'FACT'], 'number'],
            [['MIN_VALUE', 'AVG_VALUE', 'MAX_VALUE', 'VES', 'BAJARILISH', 'IVSH', 'CRITERIY_KPI'], 'number'],
            [['INPS', 'KPI_METHOD'], 'string', 'max' => 20],
            [['MFO', 'LOCAL_CODE', 'CODE_DOLJ', 'TABNUM'], 'string', 'max' => 10],
            [['CRITERIY_NAME'], 'string', 'max' => 255],
            [['CRITERIY_ALGORITHM'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PERIOD' => 'Период',
            'INPS' => 'ИНПС',
            'MFO' => 'МФО',
            'LOCAL_CODE' => 'Локал код',
            'CODE_DOLJ' => 'Лавозим коди',
            'KPI_METHOD' => 'Метод',
            'TABNUM' => 'Табель',
            'ORD' => '№',
            'CRITERIY_NAME' => 'Номи',
            'CRITERIY_ALGORITHM' => 'Алгоритм',
            'MIN_VALUE' => 'Минимум',
            'AVG_VALUE' => 'Меъёр',
            'MAX_VALUE' => 'Максимум',
            'VES' => 'Улуш',
            'PLAN' => 'План',
            'FACT' => 'Факт',
            'BAJARILISH' => 'Бажарилиши',
            'IVSH' => 'ИВШ',
            'CRITERIY_KPI' => 'КПЭ',
        ];
    }

    public static function getAllInps()
    {
        $model = self::find()->select('INPS')->where(['PERIOD'=>Period::getPeriod()])->distinct()->all();
        $items = ArrayHelper::getColumn($model,'INPS');
        return $items;
    }

    public function getEmp()
    {
        return $this->hasOne(Zagr::class, ['INPS' => 'INPS']);
    }

    public static function getKpi($inps,$period)
    {
        $model = self::find()->select('CRITERIY_KPI')->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->all();
        $i = 0;
        $p = 0;
        foreach ($model as $key) {
            $i+=$key->CRITERIY_KPI;
            $p++;
        }
        if ($p>0) {
            return round($i*100,2);
        }
        else{
            return 999;
        }
    }
}
