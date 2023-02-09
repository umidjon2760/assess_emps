<?php

namespace app\modules\baholash\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "assess_relation_group".
 *
 * @property int $ID
 * @property string|null $CODE
 * @property string|null $NAME
 */
class RelationGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_relation_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
        ];
    }

    public static function getAll()
    {
        $model = self::find()->all();
        $all = ArrayHelper::map($model,'CODE','NAME');
        return $all;
    }

    public static function getName($code)
    {
        $model = self::find()->where(['CODE'=>$code])->one();
        if ($model) {
            return $model->NAME;
        }
        else{
            return 'not_found';
        }
    }
}
