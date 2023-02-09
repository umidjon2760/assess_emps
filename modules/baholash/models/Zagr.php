<?php

namespace app\modules\baholash\models;

use Yii;
use app\modules\baholash\models\ZagrArch;
use app\modules\baholash\models\Filials;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Fact;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "assess_zagr".
 *
 * @property int $ID
 * @property int|null $CBID
 * @property int|null $INPS
 * @property string|null $MFO
 * @property string|null $LOCAL_CODE
 * @property string|null $NAME
 * @property string|null $BOLIM_CODE
 * @property string|null $BOLIM_NAME
 * @property string|null $CODE_DOLJ
 * @property string|null $LAVOZIM_NAME
 * @property string|null $TABEL
 * @property string|null $PERIOD
 */
class Zagr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_zagr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CBID'], 'integer'],
            [['PERIOD'], 'safe'],
            [['MFO', 'LOCAL_CODE', 'BOLIM_CODE', 'CODE_DOLJ', 'TABEL'], 'string', 'max' => 10],
            [['NAME', 'BOLIM_NAME', 'LAVOZIM_NAME'], 'string', 'max' => 150],
            [['NAME_NAPRAV'], 'string', 'max' => 100],
            [['INPS'], 'string', 'max' => 20],
            [['CBID','INPS'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CBID' => 'ЦБИД',
            'INPS' => 'ИНПС',
            'MFO' => 'МФО',
            'LOCAL_CODE' => 'Локал',
            'NAME' => 'ФИО',
            'BOLIM_CODE' => 'Бўлим коди',
            'BOLIM_NAME' => 'Бўлим',
            'CODE_DOLJ' => 'Лавозим коди',
            'LAVOZIM_NAME' => 'Лавозим',
            'NAME_NAPRAV' => 'Йўналиш',
            'TABEL' => 'Табель',
            'PERIOD' => 'Период',
        ];
    }

    public static function getLocalCode($inps)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->LOCAL_CODE;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->LOCAL_CODE;
            }
            else{
                return '99999';
            }
        }
    }

    public static function getLocalByInps($inps)
    {
        $mfo = Zagr::getMfo($inps);
        $model = Filials::find()->where(['MFO'=>$mfo])->one();
        if ($model) {
            return $model->LOCAL_CODE;
        }
        else{
            return '9999999';
        }
    }

    public static function getMfo($inps)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->MFO;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->MFO;
            }
            else{
                return '99999';
            }
        }
    }

    public static function getFilialEmpInps($local)
    {
        $model = self::find()->select('INPS')->where(['LOCAL_CODE'=>$local])->all();
        $items = ArrayHelper::getColumn($model,'INPS');
        return $items;
    }

    public static function getAllLocals()
    {
        $model = self::find()->all();
        $items = ArrayHelper::map($model,'LOCAL_CODE','MFO');
        $arr = [];
        foreach ($items as $local_code => $mfo) {
            $arr[$local_code] = Filials::getLocal($mfo);
        }
        return $arr;
    }

    public static function getDoljCode($id)
    {
        $idcat = static::findOne(['INPS' => $id]);
        if($idcat){
            return $idcat->CODE_DOLJ;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$id])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->CODE_DOLJ;
            }
            else{
                return 'no code';
            }
        }
    }

    public static function getName($inps)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->NAME;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->NAME;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getBolimname($inps)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->BOLIM_NAME;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->BOLIM_NAME;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getBolimnamebyPeriod($inps,$period)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->BOLIM_NAME;
        }
        else{
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->BOLIM_NAME;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getLocalbyPeriod($inps,$period)
    {
        $model = self::find()->select('LOCAL_CODE')->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->LOCAL_CODE;
        }
        else{
            $model = ZagrArch::find()->select('LOCAL_CODE')->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->LOCAL_CODE;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getCodeDoljbyPeriod($inps,$period)
    {
        $model = self::find()->select('CODE_DOLJ')->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->CODE_DOLJ;
        }
        else{
            $model = ZagrArch::find()->select('CODE_DOLJ')->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->CODE_DOLJ;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getDoljName($inps)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->LAVOZIM_NAME;
        }
        else{
            $period = date('Y-m-d', strtotime('-1 months', strtotime(Period::getPeriod()))); 
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->LAVOZIM_NAME;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getDoljNameByPeriod($inps,$period)
    {
        $model = self::find()->where(['INPS'=>$inps])->one();
        if ($model) {
            return $model->LAVOZIM_NAME;
        }
        else{
            $model = ZagrArch::find()->where(['INPS'=>$inps])->andWhere(['PERIOD'=>$period])->one();
            if ($model) {
                return $model->LAVOZIM_NAME;
            }
            else{
                return 'not_found';
            }
        }
    }

    public static function getPokazName($pokaz)
    {
        $model = Pokaz::find()->where(['CODE'=>$pokaz])->one();
        if ($model) {
            return $model->NAME;
        }
        else{
            return $pokaz;
        }
    }

    public static function getCountEmp()
    {
        return Zagr::find()->count();
    }

    public static function getUrl()
    {
        if (AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)||AccessMatrix::getAccess('admin',Yii::$app->user->ID)) {
            return '/baholash/session/fil-kpi-session';
        }
        elseif (Fact::isLovKPi(Yii::$app->user->ID)) {
            return '/baholash/zagr/baho-kpi';
        }
        elseif (Fact::isLovAll(Yii::$app->user->ID)) {
            return '/baholash/zagr/baho-all';
        }
        elseif (AccessMatrix::getAccess('co_user',Yii::$app->user->ID)) {
            return '/baholash/session/filial-baho-kpi';
        }
        else{
            return '/baholash/zagr/baho-emps-old';
        }
    }
}
