<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;

class ChangeController extends Controller
{

    public $layout = 'change';
    public function actionChangeparol()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";die;
        // if(Yii::$app->user->ID!='777'){
        //     return $this->redirect('?r=site/changeparol');
        // }

        $model = Users::find()->where(['LOGIN'=>Yii::$app->user->ID])->one();
        $err = '';
        if (isset($_POST['old_password'])) {
            $cur_password = Users::getPassword(Yii::$app->user->ID);
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $new_password1 = $_POST['new_password1'];
            // $email = $_POST['email'];
            $email = str_replace(' ', '', $_POST['email']);
            $univ = substr($email,-17);
            if ($cur_password==md5($old_password)) {
                if ($new_password==$new_password1&&$univ=='@universalbank.uz') {
                    $model->PASSWORD = md5($new_password);
                    $model->EMAIL = $email;
                    if ($model->save(false)) {
                        $email = $model->EMAIL;
                        if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                            $link = 'http://edu.universalbank.uz/baholash/web/index.php';
                            $str = 'Assalomu alaykum '.$model->NAME.'. Sizning parolingiz ozgartirildi.<br>Dasturga kirish : <a href="'.$link.'">Kirish</a><br>Login: '.$model->LOGIN.'<br>Parol: '.$new_password;
                            Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('Parol yangilandi!!!')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
                        }
                    }
                    return $this->redirect(['site/index']);
                }
                else{
                    $err = "Янги пароллар бир-бирига мос эмас ёки почта манзилингиз <b>@universalbank.uz</b> эмас!";
                }
            }
            else{
                $err = "Эски паролни нотўғри киритдингиз!";
            }
        }

        

        return $this->render('changeparol', [
            'err' => $err,
        ]);
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}