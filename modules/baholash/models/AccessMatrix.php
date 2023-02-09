<?php

namespace app\modules\baholash\models;

use Yii;
use app\modules\baholash\models\Zagr;
/**
 * This is the model class for table "assess_access_matrix".
 *
 * @property int $ID
 * @property string $TYPE
 * @property string $VALUE
 * @property string $MODUL
 * @property int $IS_EXCEPTION
 * @property string $START_DATE
 * @property string $END_DATE
 */
class AccessMatrix extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_access_matrix';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TYPE', 'VALUE', 'MODUL', 'START_DATE', 'END_DATE'], 'required'],
            [['IS_EXCEPTION'], 'integer'],
            [['START_DATE', 'END_DATE'], 'safe'],
            [['TYPE', 'VALUE', 'MODUL'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TYPE' => 'Тип',
            'VALUE' => 'Киймат',
            'MODUL' => 'Модул',
            'IS_EXCEPTION' => 'Мустасно холат',
            'START_DATE' => 'Бошлангич сана',
            'END_DATE' => 'Якуний сана',
        ];
    }
    public static function getAccess($module,$cbid)
    {
        $date = date('Y-m-d');
        $model = self::find()->where(['MODUL' => $module, 'TYPE'=>'inps', 'VALUE'=>$cbid])->andWhere(['<=','START_DATE',$date])->andWhere(['>','END_DATE',$date])->one();
        if($model)
        {
            if($model->IS_EXCEPTION==1)
                return false;
            else
                return true;
        }

        $model = self::find()->where(['MODUL' => $module, 'TYPE'=>'dolj', 'VALUE'=>Zagr::getDoljCode($cbid)])
                                ->andWhere(['<=','START_DATE',$date])
                                ->andWhere(['>','END_DATE',$date])
                                ->one();
        if($model)
        {
            if($model->IS_EXCEPTION==1)
                return false;
            else
                return true;
        }


        $model = self::find()->where(['MODUL' => $module, 'TYPE'=>'filial', 'VALUE'=>Zagr::getLocalByInps($cbid)])
                        ->andWhere(['<=','START_DATE',$date])
                        ->andWhere(['>','END_DATE',$date])
                        ->one();
        if($model)
        {
            if($model->IS_EXCEPTION==1)
                return false;
            else
                return true;
        }
    }
    public static function getModules(){
        $arr = [
                    'admin'=>'Админ',
                    'baho_admin'=>'Бахолаш(админ)',
                    'co_user'=>'Co_User',
                ];

        return $arr;
    }

    public static function getDostupTypes(){
        $arr = [
                'inps'=>'ИНПС',
                'dolj'=>'Лавозим',
                'filial'=>'Филиал',
        ];

        return $arr;
    }
}
