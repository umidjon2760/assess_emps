<?php

namespace app\modules\baholash\models;

use Yii;

/**
 * This is the model class for table "assess_zagr_arch".
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
class ZagrArch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_zagr_arch';
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
            'LOCAL_CODE' => 'Локал код',
            'NAME' => 'ФИО',
            'BOLIM_CODE' => 'Бўлим коди',
            'BOLIM_NAME' => 'Бўлим номи',
            'CODE_DOLJ' => 'Лавозим коди',
            'LAVOZIM_NAME' => 'Лавозим',
            'NAME_NAPRAV' => 'Йўналиш',
            'TABEL' => 'Табель',
            'PERIOD' => 'Период',
        ];
    }
}
