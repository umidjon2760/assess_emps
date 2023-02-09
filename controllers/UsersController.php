<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Zagr;
/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all Users models.
     * @return mixed
     */
    public $layout = 'assess';
    public function actionIndex()
    {
       if(!AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
            $this->redirect('?r=site/index');
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMyIndex()
    {
       if(!AccessMatrix::getAccess('co_user',Yii::$app->user->ID)){
            $this->redirect('?r=site/index');
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $my_local = Users::getLocalCode(Yii::$app->user->ID);
        $dataProvider->query->andWhere(['LOCAL_CODE'=>$my_local]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $id = Yii::$app->user->ID;
        if (($id!=Yii::$app->user->ID)&&!(AccessMatrix::getAccess('admin',Yii::$app->user->ID))&&!(AccessMatrix::getAccess('co_user',Yii::$app->user->ID))) {
            $id = Yii::$app->user->ID;
            // $ff = 'c';
        }
        // var_dump($ff);die;
        if (AccessMatrix::getAccess('co_user',Yii::$app->user->ID)) {
            $my_local = Users::getLocalCode(Yii::$app->user->ID);
            $model = Users::find()->where(['LOCAL_CODE'=>$my_local])->andWhere(['LOGIN'=>$id])->orderBy(['NAME'=>SORT_ASC])->one();
            if ($model) {
                return $this->render('view', [
                    'model' => $model,
                    'is_couser'=>true
                ]);
            }
            else{
                throw new NotFoundHttpException('Not found');
            }
        }
        // var_dump($id);die;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'is_couser'=>false
        ]);
    }


    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
            $this->redirect('?r=site/index');
        }
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->login]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(($id!=Yii::$app->user->ID)&&Yii::$app->user->ID!='777'){
            return $this->redirect(['updatepassword', 'id' => Yii::$app->user->ID]);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatepassword($id)
    {
        if(($id!=Yii::$app->user->ID)&&Yii::$app->user->ID!='777'){
            return $this->redirect(['updatepassword', 'id' => Yii::$app->user->ID]);
        }

        // var_dump($model);die;
        $model = $this->findModel($id);
        $err = '';

        //var_dump(Yii::$app->request->post('Users')['password']);die;
        if(Yii::$app->request->post()){
            if($model->PASSWORD==md5(Yii::$app->request->post('OLD_PASSWORD'))){
                if(Yii::$app->request->post('CONFIRM_PASSWORD')==Yii::$app->request->post('Users')['PASSWORD']){
                    $model->PASSWORD = md5(Yii::$app->request->post('Users')['PASSWORD']);
                    if($model->save(false))
                    {
                        $err = "success";
                        return $this->redirect(['view', 'id' => $id]);
                    }
                }
                else{
                    $err = 'Пароллар бир бирига мос эмас.';
                }
            }
            else{
                $err = 'Эски паролни хато киритдингиз.';
            }
        }

        

        return $this->render('updatepassword', [
            'model' => $model,
            'err' => $err,
        ]);
    }

    

    public function actionUpdatemail($id)
    {
        // echo substr("Hellaaaaaaaao@universalbank.uz",-17);die;
        if(($id!=Yii::$app->user->ID)&&Yii::$app->user->ID!='777'&&!(AccessMatrix::getAccess('co_user',Yii::$app->user->ID))){
            return $this->redirect(['updatemail', 'id' => Yii::$app->user->ID]);
        }

        $model = $this->findModel($id);
        $err = '';
        // var_dump($model);die;
        //var_dump(Yii::$app->request->post('Users')['password']);die;
        if(Yii::$app->request->post()){
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";die;
            $mail = str_replace(' ', '', $_POST['Users']['email']);
            $univ = substr($mail,-17);
            if ($univ=='@universalbank.uz') {
                $model->EMAIL = $mail;
                if ($model->save(false)) {
                    $err = "success";
                    return $this->redirect('?r=users/view&id='.$id);
                }
                else{
                    $err = 'Сақланмади';
                }
            }
            else{
                $err = 'not';
            }
            
        }

        
        return $this->render('updatemail', [
            'model' => $model,
            'err' => $err,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // var_dump($id);die;
        if (($model = Users::findOne(['LOGIN' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionResetPassword($id)
    {
        $model = Users::find()->where(['LOGIN'=>$id])->one();
        $model->PASSWORD = md5($id);
        // $model->save(false);
        if($model->save(false))
        {
            $email = Users::getEmail($id);
            if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                $link = 'http://edu.universalbank.uz/baholash/web/index.php';
                $str = 'Assalomu alaykum '.Zagr::getName($id).'. Sizning login parolingiz ozgartirildi.<br>Ushbu manzil orqali kirishingiz mumkin : <a href="'.$link.'">Kirish</a><br>Login: '.$id.'<br>Parol: '.$id;
                Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('Parol yangilandi!!!')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeleteImage($id)
    {
        $model = Users::find()->where(['LOGIN'=>$id])->one();
        if ($model) {
            if (is_dir($model->RASM)) {
                unlink($model->RASM);
            }
            $model->RASM = NULL;
            $model->save(false);
        }
        return $this->redirect('?r=users/view&id='.$id);
    }

    public function actionSavePhone()
    {
        $cbid = $_POST['cbid'];
        $phone = str_replace('-', '', $_POST['phone']);
        $model = Users::find()->where(['LOGIN'=>$cbid])->one();
        if ($model) {
            $model->PHONE_NUMBER = $phone;
            $model->save(false);
        }
        echo 'Сақланди!';
        exit;
    }

    public function actionSavePass()
    {
        $cbid = $_POST['cbid'];
        $password = $_POST['password'];
        $model = Users::find()->where(['LOGIN'=>$cbid])->one();
        $model->PASSWORD = md5($password);
        if ($model->save(false)) {
            $email = $model->EMAIL;
            if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                $link = 'http://edu.universalbank.uz/baholash/web/index.php';
                $str = 'Assalomu alaykum '.$model->NAME.'. Sizning parolingiz ozgartirildi.<br>Dasturga kirish : <a href="'.$link.'">Kirish</a><br>Login: '.$cbid.'<br>Parol: '.$password;
                Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('Parol yangilandi!!!')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
            }
        }
        echo 'Сақланди!';
        exit;
    }

    public function actionLoginAnother($id)
    {
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)) {
            $user = Users::find()->where(['LOGIN'=>$id])->one();
            if (Yii::$app->user->login($user, 3600*24*30)) {
                return $this->goBack();
            }
            else{
                return $this->redirect('?r=site/index');
            }
        }
        else{
            return $this->redirect('?r=site/index');
        }
    }
}
