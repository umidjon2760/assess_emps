<?php

namespace app\controllers;

use Yii;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Slides;
use app\models\Users;
use yii\helpers\Json;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public $layout = 'assess';
    // public $layout = 'sur';
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout='login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post())){
            if ($model->login()) {
                return $this->goBack();
            } 
        }
        

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }



    public function actionLoginme($key)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->username = $key;
        $model->password = $key;
        $model->rememberMe = 1;

        if ($model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSlidesView()
    {
        return $this->render('slides');
    }

    public function actionSlideUpload()
    {
        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";die;
        $datehash=date("Y-m-d-h-i-s-");
        $names = $_FILES['myfile']['name'];
        $i = 0;
        foreach ($names as $name) {
            $temp=$this->str2url($name);
            $temp='./files/baholash/slides/'. $datehash .$temp;
            if (move_uploaded_file($_FILES['myfile']['tmp_name'][$i], $temp)) {
                $model = new Slides;
                $model->URL = $temp;
                $model->NAME = $name;
                $model->save(false);
                $i++;
            }
        }
        return $this->redirect('?r=site/slides-view');
    }

    public function actionDownloadFile($url)
    {
        clearstatcache();
        if(file_exists($url)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($url).'"');
            header('Content-Length: ' . filesize($url));
            header('Pragma: public');
            flush(); 
            readfile($url,true);
            die();
        }
        else{
            echo "File path does not exist.";
        }
    }

    public function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => 'y',  'ы' => 'y',   'ъ' => 'y',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => 'y',  'Ы' => 'Y',   'Ъ' => 'y',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
    }


    public function str2url($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_.]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }
    public function actionSaveinfo($id)
    {
       //  var_dump($_POST);die;
       $model = Slides::findOne($id);
       // $model = AtSavollar::find()->where(['id'=>$id])->one();
       // var_dump($model);die;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $out = Json::encode(['output'=>'', 'message'=>'']); 
                echo $out;
                return;
        }
        else{
            $out = Json::encode(['output'=>'', 'message'=>'Хатолик юз берди']); 
                echo $out;
                return;
        }
    }

    public function actionDeleteSlide($id)
    {
        $model = Slides::findOne($id);
        if ($model) {
            unlink($model->URL);
            $model->delete();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRepassword(){
    	// if (!isset($kod)) {
    	// 	return $this->redirect('?r=site/index');
    	// }
        $this->layout='login';
        if (isset($_POST['LoginForm']['username'])) {
            $email = Users::getEmail($_POST['LoginForm']['username']);
            if ($email=='error@universalbank.uz') {
                $kod = $_POST['kod'];
                $err = 'No';
                return $this->render('relogin',['kod'=>$kod,'err'=>$err]);
            }
            elseif(strlen($email)==0)
            {
                $email = 'error@universalbank.uz';
            }
            else{
                $err='';
            }
            $sub = Users::getName($_POST['LoginForm']['username']).'нинг бахолаш дастури паролини тиклаш';
            $str='';
            $str.= Users::getName($_POST['LoginForm']['username']).'нинг бахолаш дастури паролини тиклаш учун';
            $str.=' жўнатилган код : ';
            $kod = $_POST['kod'];
            $str.='<span style="color:red;">'.$kod.'</span>';
            $str.='<br>Логин : '.$_POST['LoginForm']['username'];
            $cbid = $_POST['LoginForm']['username'];
            if(Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш тизими'])->setTo($email)->setSubject('Бахолаш тизими. '.$sub)->setHtmlBody('<p style="font-size:16pt; color:green;"><b>'.$str.'</b></p>')->send()){
                return $this->render('repassword',['kod'=>$kod,'cbid'=>$cbid,'mail'=>$email]);
            }
            else{
                return $this->render('relogin',['kod'=>$kod,'err'=>'dno']);
            }
        }
        if (isset($_POST['LoginForm']['yozkod'])&&isset($_POST['berkod'])) {
            if ($_POST['LoginForm']['yozkod']!=$_POST['berkod']) {
                $kod = $_POST['berkod'];
                $err = 'xato';
                return $this->render('relogin',['kod'=>$kod,'err'=>$err]);
            }
        }
        if (isset($_POST['LoginForm']['yaparol'])&&isset($_POST['LoginForm']['tasparol'])) {
            if ($_POST['LoginForm']['yaparol']!=$_POST['LoginForm']['tasparol']) {
                $kod = $_POST['berkod'];
                $err = 'parxato';
                return $this->render('relogin',['kod'=>$kod,'err'=>$err]);
            }
            $pass = $_POST['LoginForm']['yaparol'];
        }
        if (isset($_POST['cbid'])) {        
            $model = Users::find()->where(['login'=>$_POST['cbid']])->one();
            if ($model&&$pass) {
                $model->PASSWORD = md5($pass);
                if($model->save(false)){
                    return $this->redirect(['login', "err"=>"success"]);
                }
                else{
                    return $this->redirect(['login', "err"=>"warn"]);
                }
            }
        }
        return $this->render('repassword');
    }

    public function actionRelogin(){
        $this->layout='login';
        $kod = Users::randomPassword();
        return $this->render('relogin',['kod'=>$kod]);
    }
}