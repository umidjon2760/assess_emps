<?php

namespace app\modules\baholash\controllers;

use Yii;
use app\modules\baholash\models\Pokaz;
use app\modules\baholash\models\KpiCard;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\ZagrArch;
use app\models\Users;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\RelationGroup;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\RelPokaz;
use app\modules\baholash\models\Relation;
use app\modules\baholash\models\ZagrSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * ZagrController implements the CRUD actions for Zagr model.
 */
class ZagrController extends Controller
{
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all Zagr models.
     * @return mixed
     */
    public $layout = 'baho';
    public function actionIndex()
    {
        $searchModel = new ZagrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Zagr model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Zagr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Zagr();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Zagr model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Zagr model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Zagr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zagr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zagr::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload()
    {
        // if(!AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
        //     return $this->redirect('?r=site/index');
        // }
        if(isset($_FILES['myfile'])){
            $datehash=date("Y-m-d-h-i-s-");
            $name= $_FILES['myfile']['name'];
            $temp=$this->str2url($name);
            $temp='./files/baholash/zagr/'. $datehash .$temp;
            // var_dump(!is_writable($temp));die;
            if (is_writable($temp)) {
                return $this->render('upload',[
                    'err' => "not_permission",
                ]);
            }
            // var_dump(move_uploaded_file($_FILES['myfile']['tmp_name'], $temp));die;
            if(move_uploaded_file($_FILES['myfile']['tmp_name'], $temp)){
                switch ($_POST['list_type']) {
                    case 'zagruj':
                        $err = $this->myFuncZagruj($temp);
                        break;
                    case 'users':
                        $err = $this->myFuncUsers($temp);
                        break;
                    case 'relation':
                        $err = $this->myFuncRelation($temp);
                        break;
                    case 'rel_pokaz':
                        $err = $this->myFuncRelPokaz($temp);
                        break;
                    case 'kpi':
                        $err = $this->myFuncKpi($temp);
                        break;
                    default:
                        return $this->render('upload',[
                            'err' => "choosen_error",
                        ]);
                        break;
                }
                return $this->render('upload',[
                    'err' => $err,
                    'type' => $_POST['list_type'],
                ]);
            }
            else{
                return $this->render('upload',[
                    'err' => "not_move",
                ]);
            }
        }
        else{
            return $this->render('upload');
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
    ////////////////////////////////////////////////////////////////////////////////////////////////////ZAGRUJ//////////////////////////////////////////////////////////
    private function myFuncZagruj($url) {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load($url);

        $list = 0;
        $objPHPExcel->setActiveSheetIndex($list);
        $PERIOD = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();
        $PERIOD = date('d-m-Y',strtotime($PERIOD));

        if(date('d-m-Y',strtotime(Period::getPeriod()))!=$PERIOD){
            return "Сана актуал санадан фарк килади.";
        }

        if(strlen($PERIOD)==0){
            return "Сана тулдирилиши керак.";
        }
        
        $title = $objPHPExcel->getActiveSheet()->getTitle();
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 3;
        if ($title=='ZaGr') {
            while(strlen($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue())>0){
                $MFO = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                $INPS = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                
                if($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue()==''){
                    return $MFO." - шу филиалда хато бор, ".$row." қаторда ИНПС киритилмаган.";
                    die;
                }
                $model = Zagr::find()->where(['INPS'=>$INPS])->one();
                if (!$model) {
                    $model = new Zagr;
                }
                $model->MFO = $MFO;
                $model->INPS = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                $model->CBID = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                $model->BOLIM_CODE = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue();
                $model->BOLIM_NAME = $objPHPExcel->getActiveSheet()->getCell('H'.$row)->getValue();
                $model->LAVOZIM_NAME = $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
                $model->NAME = $objPHPExcel->getActiveSheet()->getCell('J'.$row)->getValue();
                $model->CODE_DOLJ = (string)$objPHPExcel->getActiveSheet()->getCell('K'.$row)->getValue();
                $model->NAME_NAPRAV = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getValue();
                $model->TABEL = (string)$objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                $model->LOCAL_CODE = (string)$objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue(); // dep code for 09012
                $model->PERIOD = date('Y-m-d',strtotime($PERIOD));

                if(!$model->save(false)){
                    foreach ($model->errors as $key => $value) {
                        $err_str = $value[0];
                    }
                    return $MFO." листида ".$row." қаторида хато бор!<br>".$err_str;
                    die;
                }
                else{
                    $t = "ok";
                }
                
                $row++;
            }
            $err = 'Success';
        }
        else{
            return "Лист номига эътибор беринг!";
            die;
        }
        return $err;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////ZAGRUJ//////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////RELATION//////////////////////////////////////////////////////////
    private function myFuncRelation($url) {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load($url);       
        $title = $objPHPExcel->getActiveSheet()->getTitle();
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 2;
        if ($title=='ReLaTiOn') {
            while(strlen($objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue())>0){
                $group_code = $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
                $nuv_dolj = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                $lov_dolj1 = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                $lov_dolj2 = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                $lov_dolj3 = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                
                $model = Relation::find()->where(['GROUP_CODE'=>$group_code])->andWhere(['NUV_DOLJ_CODE'=>$nuv_dolj])->one();
                if (!$model) {
                    $model = new Relation;
                }
                $model->GROUP_CODE = $group_code;
                $model->NUV_DOLJ_CODE = $nuv_dolj;
                $model->LOV_DOLJ_CODE1 = $lov_dolj1;
                $model->LOV_DOLJ_CODE2 = $lov_dolj2;
                $model->LOV_DOLJ_CODE3 = $lov_dolj3;
                $model->save(false);           
                $row++;
            }
            $err = 'Success';
        }
        else{
            return "Лист номига эътибор беринг!";
            die;
        }
        return $err;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////RELATION//////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////USERS//////////////////////////////////////////////////////////
    private function myFuncUsers($url) {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load($url);

        $list = 0;
        $objPHPExcel->setActiveSheetIndex($list);

        
        $title = $objPHPExcel->getActiveSheet()->getTitle();
        if($title=='UsErS'){
            $numSheets = $objPHPExcel->getSheetCount();
            $objPHPExcel->setActiveSheetIndex(0);
            $row = 2;
            while(strlen($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue())>0){
                $MFO = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                if($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue()==''){
                    return $MFO." - шу филиалда хато бор, ".$row." қаторда ИНПС киритилмаган.";
                    die;
                }else{
                    $INPS = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                }
                $CBID = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                $BOLIM_CODE = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue();
                $BOLIM_NAME = $objPHPExcel->getActiveSheet()->getCell('H'.$row)->getValue();
                $LAVOZIM_NAME = $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
                $NAME = $objPHPExcel->getActiveSheet()->getCell('J'.$row)->getValue();
                $CODE_DOLJ = (string)$objPHPExcel->getActiveSheet()->getCell('K'.$row)->getValue();
                $TABEL = (string)$objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                $LOCAL_CODE = (string)$objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue(); 
                $EMAIL = (string)$objPHPExcel->getActiveSheet()->getCell('L'.$row)->getValue(); 
                $PHONE_NUMBER = (int)$objPHPExcel->getActiveSheet()->getCell('M'.$row)->getValue(); 
                if($umodel = Users::findOne(['LOGIN' => $INPS])){
                    $umodel->MFO = $MFO;
                    $umodel->CODE_DOLJ = $CODE_DOLJ;
                    $umodel->LOCAL_CODE = $LOCAL_CODE;
                    $umodel->NAME = $NAME;
                    $umodel->BOLIM_NAME = $BOLIM_NAME;
                    $umodel->BOLIM_CODE = $BOLIM_CODE;
                    $umodel->LAVOZIM_NAME = $LAVOZIM_NAME;
                    $umodel->EMAIL = $EMAIL;
                    $umodel->PHONE_NUMBER = $PHONE_NUMBER;
                    $umodel->save(false);
                }
                else{
                    $umodel = new Users;
                    $umodel->LOGIN = $INPS;
                    $umodel->PASSWORD = md5($INPS);
                    $umodel->MFO = $MFO;
                    $umodel->CODE_DOLJ = $CODE_DOLJ;
                    $umodel->LOCAL_CODE = $LOCAL_CODE;
                    $umodel->NAME = $NAME;
                    $umodel->BOLIM_NAME = $BOLIM_NAME;
                    $umodel->BOLIM_CODE = $BOLIM_CODE;
                    $umodel->LAVOZIM_NAME = $LAVOZIM_NAME;
                    $umodel->PHONE_NUMBER = $PHONE_NUMBER;
                    $umodel->save(false);
                }
                
                $row++;
            }
            $err = 'Success';
        }
        else{
            return "Лист номига эътибор беринг!";
            die;
        }

        return $err;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////USERS//////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////REL POKAZ//////////////////////////////////////////////////////////
    private function myFuncRelPokaz($url) {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load($url);       
        $title = $objPHPExcel->getActiveSheet()->getTitle();
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 2;
        if ($title=='ReLpOkAz') {
            while(strlen($objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue())>0){
                $REL_ID = $objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue();
                $POKAZ = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                
                $model = RelPokaz::find()->where(['REL_ID'=>$REL_ID])->andWhere(['POKAZ_CODE'=>$POKAZ])->one();
                if (!$model) {
                    $model = new RelPokaz;
                    $model->REL_ID = $REL_ID;
                    $model->POKAZ_CODE = $POKAZ;
                    $model->save(false);           
                }
                else{
                    continue;
                }
                $row++;
            }
            $err = 'Success';
        }
        else{
            return "Лист номига эътибор беринг!";
            die;
        }
        return $err;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////REL POKAZ//////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////KPI//////////////////////////////////////////////////////////
    private function myFuncKpi($url) {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load($url);       
        $title = $objPHPExcel->getActiveSheet()->getTitle();
        $objPHPExcel->setActiveSheetIndex(0);
        $row = 3;
        if ($title=='KpIs') {
            while(strlen($objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue())>0){
                $period = date('Y-m-d',strtotime($objPHPExcel->getActiveSheet()->getCell('A'.$row)->getValue()));
                // var_dump($period);die;
                $inps = $objPHPExcel->getActiveSheet()->getCell('B'.$row)->getValue();
                $mfo = $objPHPExcel->getActiveSheet()->getCell('C'.$row)->getValue();
                $local_code = $objPHPExcel->getActiveSheet()->getCell('D'.$row)->getValue();
                $code_dolj = $objPHPExcel->getActiveSheet()->getCell('E'.$row)->getValue();
                $metod = $objPHPExcel->getActiveSheet()->getCell('F'.$row)->getValue();
                $tabnum = $objPHPExcel->getActiveSheet()->getCell('G'.$row)->getValue();
                $ord = $objPHPExcel->getActiveSheet()->getCell('H'.$row)->getValue();
                $name = $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
                $algoritm = $objPHPExcel->getActiveSheet()->getCell('J'.$row)->getValue();
                $min = $objPHPExcel->getActiveSheet()->getCell('K'.$row)->getValue();
                $avg = $objPHPExcel->getActiveSheet()->getCell('L'.$row)->getValue();
                $max = $objPHPExcel->getActiveSheet()->getCell('M'.$row)->getValue();
                $ves = $objPHPExcel->getActiveSheet()->getCell('N'.$row)->getValue();
                $reja = $objPHPExcel->getActiveSheet()->getCell('O'.$row)->getValue();
                $fact = $objPHPExcel->getActiveSheet()->getCell('P'.$row)->getValue();
                $baj = $objPHPExcel->getActiveSheet()->getCell('Q'.$row)->getValue();
                $ivsh = $objPHPExcel->getActiveSheet()->getCell('R'.$row)->getValue();
                $kpi = $objPHPExcel->getActiveSheet()->getCell('S'.$row)->getValue();
                
                $model = KpiCard::find()->where(['PERIOD'=>$period])->andWhere(['INPS'=>$inps])->andWhere(['ORD'=>$ord])->one();
                if (!$model) {
                    $model = new KpiCard;
                }
                $model->PERIOD = $period;
                $model->INPS = $inps;
                $model->MFO = $mfo;
                $model->LOCAL_CODE = $local_code;
                $model->CODE_DOLJ = $code_dolj;
                $model->KPI_METHOD = $metod;
                $model->TABNUM = $tabnum;
                $model->ORD = $ord;
                $model->CRITERIY_NAME = $name;
                $model->CRITERIY_ALGORITHM = $algoritm;
                $model->MIN_VALUE = $min;
                $model->AVG_VALUE = $avg;
                $model->MAX_VALUE = $max;
                $model->VES = $ves;
                $model->PLAN = $reja;
                $model->FACT = $fact;
                $model->BAJARILISH = $baj;
                $model->IVSH = $ivsh;
                $model->CRITERIY_KPI = $kpi;
                $model->save(false);           
                $row++;
            }
            $err = 'Success';
        }
        else{
            return "Лист номига эътибор беринг!";
            die;
        }
        return $err;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////KPI//////////////////////////////////////////////////////////
    public function actionBahoEmps()
    {
        $id = Yii::$app->user->ID;
        $searchModel = new ZagrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $nuvarr = Fact::getNuvArrByCbidPro($id);
        $dataProvider->query->andWhere(['in','INPS',$nuvarr]);
        $dataProvider->pagination = ['defaultPageSize'=>100];
        return $this->render('index1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBahoAll()
    {
        $id = Yii::$app->user->ID;
        $searchModel = new ZagrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $nuvarr = Fact::getNuvArrByCbidAll($id,Period::getPeriod());
        $dataProvider->query->andWhere(['in','INPS',$nuvarr]);
        $dataProvider->pagination = ['defaultPageSize'=>100];
        return $this->render('index-all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBahoKpi()
    {
        $id = Yii::$app->user->ID;
        $searchModel = new ZagrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $nuvarr = Fact::getNuvArrByCbidKpi($id,Period::getPeriod());
        $dataProvider->query->andWhere(['in','INPS',$nuvarr]);
        $dataProvider->pagination = ['defaultPageSize'=>100];
        return $this->render('index-kpi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOtchet()
    {
        return $this->render('otchet');
    }

    public function actionBahoEmpsOld()
    {
        return $this->render('index2');
    }

    public function actionEnterBahoOld()
    {
        return $this->render('index3');
    }

    public function actionGetBaholar()
    {
        if (isset($_POST['id'])) {
            $groups = RelationGroup::getAll();
            echo "<table class='table table-bordered'>";
            foreach ($_POST['id'] as $num => $period) {
                echo "<tr>";
                echo "<td colspan='4'><b>".date('d.m.Y',strtotime($period))."</b></td>";
                echo "</tr>";
                foreach ($groups as $group_code => $group_name) {
                    $facts = Fact::find()->where(['NUV_ID'=>Yii::$app->user->ID])->andWhere(['GROUP_CODE'=>$group_code])->andWhere(['PERIOD'=>$period])->all();
                    if ($facts) {
                        echo "<tr>";
                        echo "<td colspan='4'><b>".$group_name."</b></td>";
                        echo "</tr>";
                    }
                    $i = 1;
                    foreach ($facts as $fact) {
                        echo "<tr>";
                        echo "<td style='width:5%;'>".$i."</td>";
                        echo "<td style='width:40%;'>".Zagr::getPokazName($fact->POKAZ_CODE)."</td>";
                        echo "<td style='width:5%;'>".$fact->VALUE."</td>";
                        echo "<td style='width:40%;'>".$fact->COMMENT."</td>";
                        echo "</tr>";
                        $i++;
                    }
                }
            }
            echo "</table>";
        }
        else{
            echo "";
        }
        exit;
    }

    public function actionGetEnterBaholar()
    {
        if (isset($_POST['id'])) {
            $groups = RelationGroup::getAll();
            echo "<table class='table table-bordered'>";
            foreach ($_POST['id'] as $num => $period) {
                echo "<tr>";
                echo "<td colspan='7'><b>".date('d.m.Y',strtotime($period))."</b></td>";
                echo "</tr>";
                foreach ($groups as $group_code => $group_name) {
                    $facts = Fact::find()->where(['LOV_ID'=>Yii::$app->user->ID])->andWhere(['GROUP_CODE'=>$group_code])->andWhere(['PERIOD'=>$period])->all();
                    $i = 1;
                    if ($facts) {
                        echo "<tr>";
                        echo "<td colspan='7'><b>".$group_name."</b></td>";
                        echo "</tr>";
                    }
                    foreach ($facts as $fact) {
                        echo "<tr>";
                        echo "<td style='width:5%;'>".$i."</td>";
                        echo "<td style='width:15%;'>".Zagr::getName($fact->NUV_ID)."</td>";
                        echo "<td style='width:20%;'>".Zagr::getBolimnamebyPeriod($fact->NUV_ID,$period)."</td>";
                        echo "<td style='width:10%;'>".Zagr::getDoljNameByPeriod($fact->NUV_ID,$period)."</td>";
                        echo "<td style='width:20%;'>".Zagr::getPokazName($fact->POKAZ_CODE)."</td>";
                        echo "<td style='width:5%;'>".$fact->VALUE."</td>";
                        echo "<td style='width:20%;'>".$fact->COMMENT."</td>";
                        echo "</tr>";
                        $i++;
                    }

                }
            }
            echo "</table>";
        }
        else{
            echo "";
        }
        exit;
    }

    public function actionOcenka($id,$gr)
    {

        // $str = "select * from PRM_KPI_FACT where NUV_ID = '".$id."' and PERIOD = prm_api.get_oper_period order by ID";
        $rows = Fact::find()->where(['NUV_ID'=>$id])->andWhere(['LOV_ID'=>Yii::$app->user->ID])->andWhere(['PERIOD' => Period::getPeriod()])->andWhere(['GROUP_CODE'=>$gr])->orderBy(['ID'=>SORT_ASC])->all();
        $nuv_cbids = Fact::getNuvArrByCbidKpi(Yii::$app->user->ID,Period::getPeriod());
        if (in_array($id, $nuv_cbids)) {
            return $this->render('ocenka', [
                'rows' => $rows,
                'gr' => $gr,
            ]);
        }
        else{
            throw new NotFoundHttpException('Not found');
        }
        // $rows = Yii::$app->db->createCommand($str)->queryAll();

    }
    public function actionSaveocenka()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";die;
        $group_code = $_POST['group'];
        $i = 1;
        foreach ($_POST['val'] as $key => $value) {
            $model = Fact::findOne($key);
            if($model){
                $model->VALUE = $value;
                $model->COMMENT = $_POST['izoh'][$key];
                $model->save(false);
            }
            $i++;
        }
        if ($group_code == 'only_kpi') {
            return $this->redirect('?r=baholash/zagr/baho-kpi');
        }
        else{
            return $this->redirect('?r=baholash/zagr/baho-all');
        }

    }
    public function actionClosemysession($group)
    {

        $id = Yii::$app->user->ID;
        $model = Session::find()->where(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->andWhere(['LOV_ID'=>$id])->one();
        if ($model) {
            $model->SESSION_ID = 2;
            
            if ($model->save(false)) {
                $nuvs = Fact::getNuvArrByCbid($id,Period::getPeriod(),$group);
                foreach ($nuvs as $key => $nuv) {
                    $email = Users::getEmail($nuv);
                    if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                        // $sql = "insert into assess_errors values (NULL,'".$nuv."','dsdsds','pp')";
                        // Yii::$app->db->createCommand($sql)->execute();
                        $link = 'http://edu.universalbank.uz/baholash/web/index.php?r=baholash/zagr/baho-emps-old';
                        $str = 'Assalomu alaykum '.Zagr::getName($nuv).'. Hisobot oyi faoliyatingiz baholandi.<br>Ushbu manzil orqali tanishishingiz mumkin : <a href="'.$link.'">Кўриш</a><br>Sizning login : '.$nuv;
                        Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('Siz baholandingiz!!!')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
                    }
                }
            }
        }
        // return $this->redirect('?r=baholash/zagr/baho-emps');
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionArchive($key)
    {
        if(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)){
            $secret = 'a'.date('d').'a'.date('Y').'a'.date('m');
            if($key==$secret){
                $emps = Zagr::find()->all();
                foreach ($emps as $emp) {
                    $emp_arch = new ZagrArch;
                    $emp_arch->CBID = $emp->CBID;
                    $emp_arch->INPS = $emp->INPS;
                    $emp_arch->MFO = $emp->MFO;
                    $emp_arch->LOCAL_CODE = $emp->LOCAL_CODE;
                    $emp_arch->NAME = $emp->NAME;
                    $emp_arch->BOLIM_CODE = $emp->BOLIM_CODE;
                    $emp_arch->BOLIM_NAME = $emp->BOLIM_NAME;
                    $emp_arch->CODE_DOLJ = $emp->CODE_DOLJ;
                    $emp_arch->LAVOZIM_NAME = $emp->LAVOZIM_NAME;
                    $emp_arch->NAME_NAPRAV = $emp->NAME_NAPRAV;
                    $emp_arch->TABEL = $emp->TABEL;
                    $emp_arch->PERIOD = $emp->PERIOD;
                    $emp_arch->save(false);
                }
                $sql = "delete from assess_zagr";
                Yii::$app->db->createCommand($sql)->execute();
                $this->redirect(['/baholash/zagr/upload', 'err'=>'archived']);
            }
            else{
                echo 'Бу линк фаол эмас.';die;
            }
        }
        else{
            return $this->redirect('?r=site/index');
        }
    }

    public function actionOtchetV1()
    {
        $periods = $_POST['periods_v1'];
        $group = $_POST['group'];
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load('./files/baholash/otchet/otchet_v1.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $rownum = 1;
        $row = 3;
        $str_period = '';
        foreach ($periods as $period) {
            // $sheet->setCellValueExplicit('A'.$row, 'Период', \PHPExcel_Cell_DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit('A'.$row, date('d.m.Y',strtotime($period)), \PHPExcel_Cell_DataType::TYPE_STRING);
            // $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            // $row++;
            $facts = Fact::find()->where(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->orderBy(['NUV_ID'=>SORT_ASC])->all();
            foreach ($facts as $fact) {
                $emp = Zagr::find()->where(['INPS'=>$fact->NUV_ID])->andWhere(['PERIOD'=>$period])->one();
                if (!$emp) {
                    $emp = ZagrArch::find()->where(['INPS'=>$fact->NUV_ID])->andWhere(['PERIOD'=>$period])->one();
                }
                if ($emp) {
                    $local = $emp->LOCAL_CODE;
                    $bolim_name = $emp->BOLIM_NAME;
                    $lav_code = $emp->CODE_DOLJ;
                    $lav_name = $emp->LAVOZIM_NAME;
                    $name = $emp->NAME;
                }
                else{
                    $local = 'not_found';
                    $bolim_name = 'not_found';
                    $lav_code = 'not_found';
                    $lav_name = 'not_found';
                    $name = 'not_found';
                }
                $sheet->setCellValueExplicit('A'.$row, $rownum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $sheet->setCellValueExplicit('B'.$row, date('d.m.Y',strtotime($period)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$row, $fact->NUV_ID, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$row, $local, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E'.$row, $bolim_name, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('F'.$row, $lav_name, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('G'.$row, $name, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('H'.$row, $lav_code, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('I'.$row, RelationGroup::getName($fact->GROUP_CODE), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('J'.$row, $fact->LOV_ID, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('K'.$row, Zagr::getName($fact->LOV_ID), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('L'.$row, Zagr::getDoljCode($fact->LOV_ID), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('M'.$row, $fact->POKAZ_CODE, \PHPExcel_Cell_DataType::TYPE_STRING);
                if(strlen($fact->VALUE)>0){
                    $sheet->setCellValueExplicit('N'.$row, $fact->VALUE, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                }
                else{
                    $sheet->setCellValueExplicit('N'.$row, 'N', \PHPExcel_Cell_DataType::TYPE_STRING);
                }
                $sheet->setCellValueExplicit('O'.$row, $fact->COMMENT, \PHPExcel_Cell_DataType::TYPE_STRING);
                $row++;
                $rownum++;
            }
            $row++;
            $str_period.='_'.date('d_m_Y',strtotime($period));
        }
        $border = array(
            'borders'=>array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            )
        );

        $sheet->getStyle("A1:O".($row-1))->applyFromArray($border);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет_V1'.$str_period.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->setPreCalculateFormulas(false);

        $path = './files/baholash/otchet/Отчет_V1'.$str_period.'.xlsx';
        $objWriter->save($path);
        header("Content-Length: ".filesize($path));
        readfile($path);
        unlink($path);
        // ob_end_clean();
        // $objWriter->save('php://output');
        //без этой строки при открытии файла xlsx ошибка!!!!!!
        exit;
    }

    public function actionOtchetV2()
    {
        $periods = $_POST['periods_v2'];
        $group = $_POST['group'];
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load('./files/baholash/otchet/otchet_v2.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $rownum = 1;
        $row = 3;
        $pokazs = Pokaz::getall();
        $harf_arr = ['H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V'];
        $i = 0;
        foreach ($pokazs as $pokaz_code => $pokaz_name) {
            $sheet->setCellValueExplicit($harf_arr[$i].'2', $pokaz_code, \PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
        }
        if ($i>0) {
            $last_harf = $harf_arr[($i-1)];
        }
        else{
            $last_harf = 'G';
        }
        // var_dump($periods);die;
        $str_period = '';
        foreach ($periods as $period) {
            // $sheet->setCellValueExplicit('A'.$row, 'Период', \PHPExcel_Cell_DataType::TYPE_STRING);
            // $sheet->setCellValueExplicit('A'.$row, date('d.m.Y',strtotime($period)), \PHPExcel_Cell_DataType::TYPE_STRING);
            // $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            // $row++;
            $nuv_ids = Fact::find()->select('NUV_ID')->where(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$group])->distinct()->all();
            foreach ($nuv_ids as $nuv_id) {
                $sheet->setCellValueExplicit('A'.$row, $rownum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $sheet->setCellValueExplicit('B'.$row, date('d.m.Y',strtotime($period)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('C'.$row, $nuv_id->NUV_ID, \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('D'.$row, Zagr::getName($nuv_id->NUV_ID), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('E'.$row, Zagr::getLocalbyPeriod($nuv_id->NUV_ID,$period), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('F'.$row, Zagr::getCodeDoljbyPeriod($nuv_id->NUV_ID,$period), \PHPExcel_Cell_DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('G'.$row, RelationGroup::getName($group), \PHPExcel_Cell_DataType::TYPE_STRING);
                $i = 0;
                foreach ($pokazs as $pokaz_code => $pokaz_name) {
                    $ocenka = Fact::getValueStr($nuv_id->NUV_ID,$period,$pokaz_code,$group);
                    //$sheet->setCellValueExplicit($harf_arr[$i].$row, Fact::getValue($nuv_id->NUV_ID,$period,$pokaz_code,$group), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    if($ocenka!='no'&&strlen($ocenka)>0){
                        $sheet->setCellValueExplicit($harf_arr[$i].$row, $ocenka, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    }
                    else{
                        $sheet->setCellValueExplicit($harf_arr[$i].$row, 'N', \PHPExcel_Cell_DataType::TYPE_STRING);
                    }
                    $i++;
                }
                $row++;
                $rownum++;
            }
            $row++;
            $str_period.='_'.date('d_m_Y',strtotime($period));
        }
        $border = array(
            'borders'=>array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            )
        );
        $sheet->getStyle("A1:".$last_harf.($row-1))->applyFromArray($border);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет_V2'.$str_period.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->setPreCalculateFormulas(false);

        $path = './files/baholash/otchet/Отчет_V2'.$str_period.'.xlsx';
        $objWriter->save($path);
        header("Content-Length: ".filesize($path));
        readfile($path);
        unlink($path);
        // ob_end_clean();
        // $objWriter->save('php://output');
        //без этой строки при открытии файла xlsx ошибка!!!!!!
        exit;
    }

    public function actionOtchetUser()
    {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load('./files/baholash/otchet/otchet_user.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $rownum = 1;
        $row = 2;
        $users = Users::find()->orderBy(['NAME'=>SORT_ASC])->all();
        foreach ($users as $user) {
            $sheet->setCellValueExplicit('A'.$row, $rownum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('B'.$row, $user->LOGIN, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C'.$row, $user->NAME, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D'.$row, $user->BOLIM_NAME, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E'.$row, $user->LAVOZIM_NAME, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F'.$row, $user->MFO, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G'.$row, $user->LOCAL_CODE, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H'.$row, $user->CODE_DOLJ, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('I'.$row, $user->EMAIL, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('J'.$row, ((strlen($user->PHONE_NUMBER)>0) ? '998'.$user->PHONE_NUMBER : ''), ((strlen($user->PHONE_NUMBER)>0) ? \PHPExcel_Cell_DataType::TYPE_NUMERIC : \PHPExcel_Cell_DataType::TYPE_STRING));
            $row++;
            $rownum++;
        }
        $border = array(
            'borders'=>array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            )
        );
        $sheet->getStyle("A1:J".($row-1))->applyFromArray($border);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // echo "<pre>";
        // print_r($objWriter);
        // echo "</pre>";die;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет_user.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->setPreCalculateFormulas(false);

        $path = './files/baholash/otchet/Отчет_user.xlsx';
        $objWriter->save($path);
        header("Content-Length: ".filesize($path));
        readfile($path);
        unlink($path);
        // ob_end_clean();
        // $objWriter->save('php://output');
        //без этой строки при открытии файла xlsx ошибка!!!!!!
        exit;
    }

    public function actionOtchetRelation()
    {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load('./files/baholash/otchet/otchet_relation.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $rownum = 1;
        $row = 2;
        $relations = Relation::find()->all();
        foreach ($relations as $relation) {
            $sheet->setCellValueExplicit('A'.$row, $rownum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('B'.$row, $relation->ID, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('C'.$row, $relation->GROUP_CODE, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D'.$row, RelationGroup::getName($relation->GROUP_CODE), \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E'.$row, $relation->NUV_DOLJ_CODE, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F'.$row, $relation->LOV_DOLJ_CODE1, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G'.$row, $relation->LOV_DOLJ_CODE2, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H'.$row, $relation->LOV_DOLJ_CODE3, \PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
            $rownum++;
        }
        $border = array(
            'borders'=>array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            )
        );
        $sheet->getStyle("A1:H".($row-1))->applyFromArray($border);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет_relation.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->setPreCalculateFormulas(false);

        $path = './files/baholash/otchet/Отчет_relation.xlsx';
        $objWriter->save($path);
        header("Content-Length: ".filesize($path));
        readfile($path);
        unlink($path);

        // ob_end_clean();
        // $objWriter->save('php://output');
        //без этой строки при открытии файла xlsx ошибка!!!!!!
        exit;
    }
    public function actionOtchetRelationPokaz()
    {
        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel = \PHPExcel_IOFactory::load('./files/baholash/otchet/otchet_relation_pokaz.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $rownum = 1;
        $row = 2;
        $relations = RelPokaz::find()->orderBy(['REL_ID'=>SORT_ASC])->all();
        foreach ($relations as $relation) {
            $sheet->setCellValueExplicit('A'.$row, $rownum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('B'.$row, $relation->REL_ID, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $sheet->setCellValueExplicit('C'.$row, $relation->POKAZ_CODE, \PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D'.$row, Zagr::getPokazName($relation->POKAZ_CODE), \PHPExcel_Cell_DataType::TYPE_STRING);
            $row++;
            $rownum++;
        }
        $border = array(
            'borders'=>array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                ),
            )
        );
        $sheet->getStyle("A1:D".($row-1))->applyFromArray($border);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет_relation_pokaz.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->setPreCalculateFormulas(false);
        $path = './files/baholash/otchet/Отчет_relation_pokaz.xlsx';
        $objWriter->save($path);
        header("Content-Length: ".filesize($path));
        readfile($path);
        unlink($path);
        // ob_end_clean();
        // $objWriter->save('php://output');
        //без этой строки при открытии файла xlsx ошибка!!!!!!
        exit;
    }
    
    public function actionImgUpload()
    {
        
        if ($_FILES['myfile']['size'] > 524288)
        {
            echo "0,5 МБ дан кичик файл юклашингиз керак. ";
        }
        else{
            $inps = $_POST['inps'];
            $model = Users::find()->where(['LOGIN'=>$inps])->one();
            if ($model) {
                if (is_dir($model->RASM)) {
                    unlink($model->RASM);
                }
                $model->RASM = NULL;
                $model->save(false);
            }
            $type = $_FILES['myfile']['type'];
            $type_arr = explode('/', $type);
            $type = $type_arr[1];
            $datehash=date("Y-m-d-h-i-s-");
            $temp='./files/baholash/images/img_'.$inps.".".$type;
            if ($model) {
                $model->RASM = $temp;
                $model->save(false);
            }
            move_uploaded_file($_FILES['myfile']['tmp_name'], $temp);
            return $this->redirect('?r=users/view&id='.$inps);
        }
    }

    public function actionSendMessageForSession($BuBIU78rvu7CF876cvd8ws7nvgdsa)
    {
        set_time_limit(1000);
        $sessions = Session::find()->where(['PERIOD'=>Period::getPeriod()])->andWhere(['SESSION_ID'=>'1'])->andWhere(['GROUP_CODE'=>$BuBIU78rvu7CF876cvd8ws7nvgdsa])->all();
        if ($BuBIU78rvu7CF876cvd8ws7nvgdsa=='only_360') {
            $link = 'http://edu.universalbank.uz/baholash/web/index.php?r=baholash/zagr/baho-all';
        }
        else{
            $link = 'http://edu.universalbank.uz/baholash/web/index.php?r=baholash/zagr/baho-kpi';
        }
        foreach ($sessions as $session) {
            $email = Users::getEmail($session->LOV_ID);
            if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                $str = 'Assalomu alaykum '.Zagr::getName($session->LOV_ID).'. Hodimlaringizni hisobot oyi faoliyati buyicha baholang.<br>Ushbu manzil orqali baholanadi : <a href="'.$link.'">Кўриш</a><br>Sizning login : '.$session->LOV_ID;
                Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('Hodimlaringizni baholang!!!')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
            }
            else{
                continue;
            }
        }
        if ($BuBIU78rvu7CF876cvd8ws7nvgdsa=='only_360') {
            return $this->redirect('?r=baholash/session/fil-all-session&Hujuiku765d5ddQHu3nds=dwdcdfew');
        }
        else{
            return $this->redirect('?r=baholash/session/fil-kpi-session&Hujuiku765d5ddQHu3nds=dwdcdfew');
        }
    }

    public function actionSendToEmpKpi()
    {
        set_time_limit(1000);
        $kpi_inpss = KpiCard::getAllInps();
        foreach ($kpi_inpss as $kpi_inps) {
            $email = Users::getEmail($kpi_inps);
            if ($email!='error@universalbank.uz'&&strlen($email)>16) {
                $str = "Assalomu alaykum ".Zagr::getName($kpi_inps).". KPI natijalaringiz bilan tanishing.<br>Ushbu manzil orqali kurishingiz mumkin : <a href='http://edu.universalbank.uz/baholash/web/index.php?r=baholash/kpi-card/my-kpi'>Кўриш</a><br>Sizning login : ".$kpi_inps;
                Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($email)->setSubject('KPI natijalaringiz bilan tanishing.')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$str.'</b></p>')->send();
            }
            else{
                continue;
            }
        }
        return $this->redirect('?r=baholash/kpi-card/all');
    }

    public function actionPochta()
    {
        if ($_POST) {
            Yii::$app->mailer->compose()->setFrom(['abduvali.ruziev@universalbank.uz'=>'Бахолаш'])->setTo($_POST['email'])->setSubject('TEST')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$_POST['text'].'</b></p>')->send();
        }
        return $this->render('pochta');
    }

    public function actionEmpKpi()
    {
        if(AccessMatrix::getAccess('admin',Yii::$app->user->ID))
        {
            $searchModel = new ZagrSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);            
        }
        elseif(AccessMatrix::getAccess('co_user',Yii::$app->user->ID))
        {
            $searchModel = new ZagrSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $my_local = Zagr::getLocalByInps(Yii::$app->user->ID);
            $baho_emps = Fact::getNuvArrByCbidPro(Yii::$app->user->ID);
            $filial_emps_inps = Zagr::getFilialEmpInps($my_local);
            $inps_arr = [];
            foreach ($filial_emps_inps as $fil_inps) {
                $inps_arr[$fil_inps] = $fil_inps;
            }
            foreach ($baho_emps as $baho_inps) {
                $inps_arr[$baho_inps] = $baho_inps;
            }
            $dataProvider->query->andWhere(['in','INPS',$inps_arr]);
        }

        return $this->render('kpi-emp', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQueryToReal()
    {
        if(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))
        {
            if (isset($_POST['zapros'])) {        
                $str = $_POST['zapros'];
                return $this->render('zaprostoreal', [
                    'str'=>$str
                ]);
            }
            return $this->render('zaprostoreal');
        }
        else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
