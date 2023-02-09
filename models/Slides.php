<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "assess_slides".
 *
 * @property int $id
 * @property string|null $url
 * @property int|null $name
 */
class Slides extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_slides';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ORD'], 'integer'],
            [['ORD'], 'unique'],
            [['URL'], 'string', 'max' => 100],
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
            'URL' => 'Url',
            'NAME' => 'Name',
            'ORD' => 'Ord',
        ];
    }
}
