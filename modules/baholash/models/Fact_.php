<?php

namespace app\modules\baholash\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\baholash\models\Pokaz;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Zagr;
/**
 * This is the model class for table "assess_fact".
 *
 * @property int $ID
 * @property int|null $LOV_ID
 * @property int|null $NUV_ID
 * @property string|null $POKAZ_CODE
 * @property int|null $VALUE
 * @property string|null $COMMENT
 * @property string|null $PERIOD
 */
class Fact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    // public = '2022-09-01';
    public static function tableName()
    {
        return 'assess_fact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PERIOD'], 'safe'],
            [['POKAZ_CODE','GROUP_CODE'], 'string', 'max' => 50],
            [['NUV_ID','LOV_ID'], 'string', 'max' => 20],
            [['COMMENT'], 'string', 'max' => 255],
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
            'LOV_ID' => 'Бахоловчи',
            'NUV_ID' => 'Бахоланувчи',
            'POKAZ_CODE' => 'Показ',
            'VALUE' => 'Қиймат',
            'COMMENT' => 'Изох',
            'PERIOD' => 'Период',
        ];
    }

    public function getLovmfo()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'LOV_ID']);
    }

    public function getLovcodedolj()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'LOV_ID']);
    }

    public function getNuvmfo()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'NUV_ID']);
    }

    public function getNuvcodedolj()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'NUV_ID']);
    }

    public static function isLov($inps,$check)
    {
        if ($check=='now') {
            $model = self::find()->where(['LOV_ID'=>$inps])->andWhere(['PERIOD'=>Period::getPeriod()])->one();
            if ($model) {
                return true;
            }
            else{
                return false;
            }
        }
        elseif ($check=='all') {
            $model = self::find()->where(['LOV_ID'=>$inps])->one();
            if ($model) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $model = self::find()->where(['LOV_ID'=>$inps])->andWhere(['not in','PERIOD',[Period::getPeriod()]])->one();
            if ($model) {
                return true;
            }
            else{
                return false;
            }
        }
    }

    public static function isLovAll($inps)
    {
        $model = self::find()->where(['LOV_ID'=>$inps])->andWhere(['GROUP_CODE'=>'only_360'])->andWhere(['PERIOD'=>Period::getPeriod()])->one();
        if ($model) {
            return true;
        }
        else{
            return false;
        }
    }
    public static function isLovKpi($inps)
    {
        $model = self::find()->where(['LOV_ID'=>$inps])->andWhere(['GROUP_CODE'=>'only_kpi'])->andWhere(['PERIOD'=>Period::getPeriod()])->one();
        if ($model) {
            return true;
        }
        else{
            return false;
        }
    }
    public static function isNuv($inps)
    {
        $model = self::find()->where(['NUV_ID'=>$inps])->one();
        if ($model) {
            return true;
        }
        else{
            return false;
        }
    }
    public static function getNuvArrByCbidPro($cbid)
    {
        $model = self::find()->select('NUV_ID')->where(['LOV_ID'=>$cbid])->andWhere(['PERIOD'=>Period::getPeriod()])->asArray()->all();
        $items = ArrayHelper::getColumn($model,'NUV_ID');
        return $items;
               
    }

    public static function getNuvArrByCbidAll($cbid,$period)
    {
        $model = self::find()->select('NUV_ID')->where(['LOV_ID'=>$cbid])->andWhere(['GROUP_CODE'=>'only_360'])->andWhere(['PERIOD'=>$period])->asArray()->all();
        $items = ArrayHelper::getColumn($model,'NUV_ID');
        return $items;
               
    }
    public static function getNuvArrByCbidKpi($cbid,$period)
    {
        $model = self::find()->select('NUV_ID')->where(['LOV_ID'=>$cbid])->andWhere(['GROUP_CODE'=>'only_kpi'])->andWhere(['PERIOD'=>$period])->asArray()->all();
        $items = ArrayHelper::getColumn($model,'NUV_ID');
        return $items;
               
    }
    public static function getNuvArrByCbid($cbid,$period,$group)
    {
        $model = self::find()->select('NUV_ID')->where(['LOV_ID'=>$cbid])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>$period])->distinct()->all();
        $items = ArrayHelper::getColumn($model,'NUV_ID');
        return $items;
               
    }
    public static function getOtsenki($nuv_cbid,$group,$period)
    {
        $model = self::find()->where(['NUV_ID'=>$nuv_cbid])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>$period])->all();
        $str='';
        if (count($model)>0) {
            $str.="<table border='1'>";
            $str.="<tr>";
            foreach ($model as $key) {
                if (isset($key->VALUE)) {
                    
                    $value = $key->VALUE;
                }
                else{
                    $value = '-';
                }
                $str.="<td>".$value."</td>";
            }
            $str.="</tr>";
            $str.="</table>";
        }
        return $str;

    }

    public static function getOtsenkiLov($nuv_cbid,$lov_cbid,$group,$period)
    {
        $model = self::find()->where(['NUV_ID'=>$nuv_cbid])->andWhere(['LOV_ID'=>$lov_cbid])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>$period])->all();
        $str='';
        if (count($model)>0) {
            $str.="<table border='1'>";
            $str.="<tr>";
            foreach ($model as $key) {
                if (isset($key->VALUE)) {
                    
                    $value = $key->VALUE;
                }
                else{
                    $value = '-';
                }
                $str.="<td>".$value."</td>";
            }
            $str.="</tr>";
            $str.="</table>";
        }
        return $str;

    }

    public static function getOtsenkiColor($nuv_cbid,$group,$period)
    {
        $model = self::find()->where(['NUV_ID'=>$nuv_cbid])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->all();
        if (count($model)>0) {
            $i = 0;
            foreach ($model as $key) {
                if (isset($key->VALUE)) {
                    $value = $key->VALUE;
                }
                else{
                    $value = '-';
                    $i++;
                }
            }
        }
        return $i;

    } 
    public static function getMyInfoFull($group){
        $lov_tabnum = Yii::$app->user->ID;

        $model = self::find()->where(['LOV_ID'=>$lov_tabnum,])->andWhere(['GROUP_CODE'=>$group])->andWhere('VALUE is null')->andWhere(['PERIOD'=>Period::getPeriod()])->count();
        if($model==0){
            return 1;
        }
        else{
            return 2;
        }
    }
    public static function getClass($id,$group)
    {
        $lov_id = Yii::$app->user->ID;
        $model = self::find()->where(['LOV_ID'=>$lov_id,'NUV_ID'=>$id])->andWhere('VALUE is null')->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->count();
        // var_dump($id);die;
        if($model==0){
            $class='green';
            return ['class'=>$class];
        }
        else{
            $res1 = $model;
        }

        $model = self::find()->where(['LOV_ID'=>$lov_id,'NUV_ID'=>$id])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->count();
        if($model==0){
            $res2=1;
        }
        else{
            $res2=$model;
        }

        $res=$res1/$res2;

        if($res==0){
            $class='green';
        }
        elseif($res>0&&$res<1){
            $class='orange';
        }
        else{
            $class='red';
        }

        return ['class'=>$class];
    }
    public static function getLink($id,$group){
        $session = Session::getSessionMe($group);
        if($session==1){
            return "<a href='?r=baholash/zagr/ocenka&id=".$id."&gr=".$group."'>Бахолаш</a>";
        }
        else{
            //return "<span style='color:white'>Сессия ёпилган.</span>";
            return "<a href='?r=baholash/zagr/ocenka&id=".$id."&gr=".$group."'>Бахолар</a>";
        }

    }

    public static function getPokaz($id)
    {
        $model = self::find()->where(['ID'=>$id])->one();
        if ($model) {
            return $model->POKAZ_CODE;
        }
        else{
            return $id;
        }
    }

    public static function getValue($inps,$period,$pokaz,$group)
    {
        $model = self::find()->where(['NUV_ID'=>$inps])->andWhere(['POKAZ_CODE'=>$pokaz])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->one();
        if ($model) {
            return $model->VALUE;
        }
        else{
            return 0;
        }
    }

    public static function getValueStr($inps,$period,$pokaz,$group)
    {
        $model = self::find()->where(['NUV_ID'=>$inps])->andWhere(['POKAZ_CODE'=>$pokaz])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->one();
        if ($model) {
            return $model->VALUE;
        }
        else{
            return 'no';
        }
    }

    public static function getAvgValue($inps,$period,$group)
    {
        $model = self::find()->where(['NUV_ID'=>$inps])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->all();
        $i = 0;
        $sum = 0;
        foreach ($model as $key) {
            $sum+=$key->VALUE;
            $i++;
        }
        if ($i==0) {
            $avg = 0;
        }
        else{
            $avg = round(($sum/$i),1);
        }
        return $avg;
    }

    public static function getBahoOrNot($lov_id,$period,$group)
    {
        $nuv_ids = self::find()->select('NUV_ID')->where(['LOV_ID'=>$lov_id])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->distinct()->all();
        $all = 0;
        $baholangan = 0;
        // var_dump(count($nuv_ids));die;
        foreach ($nuv_ids as $key1 => $value1) {
            $model = self::find()->where(['LOV_ID'=>$lov_id])->andWhere(['NUV_ID'=>$value1->NUV_ID])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->all();
            $i = 0;
            $p = 0;
            foreach ($model as $key) {
                if (strlen($key->VALUE)>0) {
                    $i++;
                }
                $p++;
            }
            if ($i==$p) {
                $baholangan+=1;
            }
            $all++;
        }
        return $baholangan.'/'.$all;
    }

    public static function getValueList($id,$group)
    {
        $session = Session::getSessionMe($group);
        $model = self::findOne($id);
        if($model){
            $value = $model->VALUE;              
        }
        else{
            $value = '';
        }        
        $pokaz = $model->POKAZ_CODE;

        $max = Pokaz::getMaxMinValue($pokaz,'max');
        $min = Pokaz::getMaxMinValue($pokaz,'min');
        if($session!=1){
            $ret = "<input type='number' class='form-control' disabled='disabled' min='".$min."' max='".$max."' value='{$value}' name='val[".$id."]' placeholder='".$min." - ".$max." оралиғида бахо қўйинг...'>";
        }
        else{
            $ret = "<input type='number' onchange='checkParams($id)' min='".$min."' max='".$max."' required id='val".$id."' value='{$value}' class='form-control' name='val[".$id."]' placeholder='".$min." - ".$max." оралиғида бахо қўйинг...'>";
        }

        return $ret;
    }

    public static function geIzoh($id,$group)
    {
        $session = Session::getSessionMe($group);
        $model = self::findOne($id);
       
        $ret = "<textarea id='izoh$id' class='form-control'";
        if($session!=1){
            $ret.=" disabled='disabled' ";
        }
        $ret.="name='izoh[".$id."]'>";
        if($model){
            $ret.=$model->COMMENT; 
        }
        $ret.="</textarea>";


        return $ret;
    }
}
