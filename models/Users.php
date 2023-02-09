<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "users".
 *
 * @property string $LOGIN
 * @property string $PASSWORD
 * @property string $MFO
 * @property string $CODE_DOLJ
 * @property string $napr
 * @property string $name
 * @property string $arm
 * @property string $bolim_name
 * @property string $lavozim_name
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assess_users';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LOGIN', 'PASSWORD', 'MFO', 'CODE_DOLJ', 'NAME', 'BOLIM_NAME', 'LAVOZIM_NAME'], 'required'],
            [['LOGIN'], 'string', 'max' => 20],
            [['PASSWORD', 'arm'], 'string', 'max' => 30],
            [['MFO'], 'string', 'max' => 5],
            [['EMAIL'], 'string', 'max' => 100],
            [['CODE_DOLJ', 'napr'], 'string', 'max' => 10],
            [['NAME'], 'string', 'max' => 100],
            [['BOLIM_NAME', 'LAVOZIM_NAME','RASM'], 'string', 'max' => 255],
            [['LOGIN'], 'unique'],
            [['PHONE_NUMBER'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LOGIN' => 'Логин',
            'PASSWORD' => 'Пароль',
            'MFO' => 'МФО',
            'CODE_DOLJ' => 'Лавозим коди',
            'NAME' => 'ФИО',
            'LOCAL_CODE' => 'Локал',
            'BOLIM_CODE' => 'Булим коди',
            'BOLIM_NAME' => 'Булим',
            'LAVOZIM_NAME' => 'Лавозим',
            'EMAIL' => 'Почта',
            'PHONE_NUMBER' => 'Телефон номер',
        ];
    }
    public static function findIdentity($id)
    {

        return static::findOne(['LOGIN' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
     
        return static::findOne(['LOGIN' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->LOGIN;
    }

    // public static function getId1()
    // {
    //     return $this->LOGIN;
    // }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates PASSWORD
     *
     * @param string $PASSWORD PASSWORD to validate
     * @return bool if PASSWORD provided is valid for current user
     */
    public function validatePassword($password)
    {
        if($this->PASSWORD==md5($password)){
            return true;
        }
        else{
            return false;
        }
    }

    // public function validatePassword($password){
    //     return \Yii::$app->security->validatePassword($password, $this->password);
    // }
    // public function setPassword($password){
    //     $this->password = \Yii::$app->security->generatePasswordHash($password);
    // }

    public static function getShortName($id)
    {
        //Axmadjonov U.E.
        // var_dump(Yii::$app->user->ID);die;
        if ($id==777) {
            return 'Админ';
        }
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat)
        $str = $idcat->NAME;
        $pieces = explode(" ", $str);
        mb_internal_encoding("UTF-8");
        if(isset($pieces[1])){
            $str1=mb_substr($pieces[1],0,1);
        }
        else{
            $str1='';
        }
        if(isset($pieces[2])){
            $str2=mb_substr($pieces[2],0,1);
        }
        else{
            $str2='';
        }
        // var_dump(expression)
        return $pieces[0].' '.$str1.'. '.$str2.'.';
    }

    public static function getSmallName($id)
    {
        //U.Axmadjonov
        if ($id==777) {
            return 'Админ';
        }
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat)
        $str = $idcat->NAME;
        $pieces = explode(" ", $str);
        mb_internal_encoding("UTF-8");
        if(isset($pieces[1])){
            $str1=mb_substr($pieces[1],0,1);
        }
        else{
            $str1='';
        }
        // var_dump($pieces[0]);die;
        return $str1.'. '.$pieces[0];
    }

    public static function getName($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat){
            return $idcat->NAME;
        }
        else{
            return "Не найден!";
        }
    }


    public static function getDoljName($tabnum)
    {
        $idcat = static::findOne(['LOGIN' => $tabnum]);
        if($idcat)
        return $idcat->LAVOZIM_NAME;
    }

    public static function getPassword($login)
    {
        $idcat = static::findOne(['LOGIN' => $login]);
        if($idcat)
        return $idcat->PASSWORD;
    }

    public static function getMyCodeDolj()
    {
        $idcat = static::findOne(['LOGIN' => Yii::$app->user->ID]);
        if($idcat)
        return $idcat->CODE_DOLJ;
    }

    public static function getCodeDolj($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat)
        return $idcat->CODE_DOLJ;
    }

    public static function getMyMfo()
    {
        $idcat = static::findOne(['LOGIN' => Yii::$app->user->ID]);
        if($idcat)
        return $idcat->MFO;
    }

    public static function getMfo($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat){
            return $idcat->MFO;
        }
        else{
            return '00000';
        }
    }

    public static function getLocalCode($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat){
            return $idcat->LOCAL_CODE;
        }
        else{
            return '000007777';
        }
    }


    public static function getUsersCbid()
    {
        $emps = Users::find()->select('LOGIN')
                ->orderBy(['MFO'=>SORT_DESC])->asArray()
                ->all();
        $emp_arr = ArrayHelper::getColumn($emps,'LOGIN');

        return $emp_arr;
    }

    public static function getEmail($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat){
            return $idcat->EMAIL;
        }
        else{
            return 'error@universalbank.uz';
        }
    }

    public static function getRasm($id)
    {
        $idcat = static::findOne(['LOGIN' => $id]);
        if($idcat&&strlen($idcat->RASM)>0){
            return $idcat->RASM;
        }
        else{
            return './files/baholash/images/user2-160x160.jpg';
        }
    }


    public static function randomPassword(){
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = [];
        $alphaLength = strlen($alphabet)-1;
        for ($i=0; $i < 8; $i++) { 
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }


}
