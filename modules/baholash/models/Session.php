<?php

namespace app\modules\baholash\models;

use Yii;
use app\modules\baholash\models\Zagr;
/**
 * This is the model class for table "assess_session".
 *
 * @property int $ID
 * @property int|null $LOV_ID
 * @property int|null $SESSION_ID
 * @property string|null $PERIOD
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SESSION_ID'], 'integer'],
            [['PERIOD','MFO','LOV_ID','GROUP_CODE'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'GROUP_CODE' => 'Гурух',
            'MFO' => 'Локал код',
            'LOV_ID' => 'Бахоловчи',
            'SESSION_ID' => 'Сессия',
            'PERIOD' => 'Период',
        ];
    }

    public function getLovmfo()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'LOV_ID']);
    }
    public function getLovname()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'LOV_ID']);
    }
    public function getLovcodedolj()
    {
        return $this->hasOne(Zagr::className(), ['INPS' => 'LOV_ID']);
    }
    public static function getclassForFilial($res)
    {

        if($res=='Нет информации'||$res=='0%'){
            $ret='mynull';
        }
        elseif($res=='100%'){
            $ret = 'myfull';
        }
        else{
            $ret = 'mypart';
        }

        return $ret;
        
    }

    public static function getSessionForFilial($code,$group)
    {
        $r1 = self::find()->where(['MFO'=>$code,'SESSION_ID'=>2])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->count();
        $r2 = self::find()->where(['MFO'=>$code])->andWhere(['in','SESSION_ID',[1,2]])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->count();
        if($r2==0){
            return "Бахолаш очилмаган";
        }
        else{
            $r = round(($r1/$r2),2)*100;
            return $r.'%';
        }
    }
    public static function getName($id)
    {
        $arr = self::getAll();

        return $arr[$id];
    }
    public static function getAll()
    {
        $arr = [
            1=>'Бахолашга очик',
            2=>'Бахолаш ёпик'
        ];
        return $arr;
    }
    public static function getSessionMe($group)
    {
        $mfo = Zagr::getLocalByInps(Yii::$app->user->ID);
        $id=Yii::$app->user->ID;
        $res = self::find()->where(['MFO'=>$mfo])->andWhere(['GROUP_CODE'=>$group])->andWhere(['LOV_ID'=>$id])->andWhere(['PERIOD'=>Period::getPeriod()])->one();
        if($res){
            return $res->SESSION_ID;
        }
        else{
            return 0;
        }
    }
}
