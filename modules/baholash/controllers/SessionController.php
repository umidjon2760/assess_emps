<?php

namespace app\modules\baholash\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\ZagrArch;
use app\modules\baholash\models\ZagrSearch;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\SessionSearch;
use yii\web\Controller;
use kartik\grid\GridView;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * SessionController implements the CRUD actions for Session model.
 */
class SessionController extends Controller
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
     * Lists all Session models.
     * @return mixed
     */
    public $layout = 'baho';
    public function actionIndex()
    {
        $searchModel = new SessionSearch();
        $searchModel->PERIOD = Period::getPeriod();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Session model.
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
     * Creates a new Session model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Session();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Session model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            // return $this->redirect(['view', 'id' => $model->ID]);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Session model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
        // return $this->redirect(['index']);
    }

    /**
     * Finds the Session model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Session the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Session::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFilSession()
    {
        return $this->render('indexsess');
    }
    public function actionFilAllSession()
    {
        return $this->render('indexallsess');
    }
    public function actionFilKpiSession()
    {
        return $this->render('indexkpisess');
    }

    public function actionOpenalltoone($group)
    {
        $lov_emps = Fact::find()->select('LOV_ID')->where(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->distinct()->asArray()->all();
        $lov_emps = ArrayHelper::getColumn($lov_emps,'LOV_ID');
        foreach ($lov_emps as $lov_emp) {
            if ($lov_emp!='not_found_inps') {
                $session = Session::find()->where(['LOV_ID'=>$lov_emp])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->one();
                if (!$session) {
                    $model = new Session;
                    $model->PERIOD = Period::getPeriod();
                    $model->MFO = Zagr::getLocalByInps($lov_emp);
                    $model->SESSION_ID = '1';
                    $model->GROUP_CODE = $group;
                    $model->LOV_ID = $lov_emp;
                    $model->save(false);
                }
                else{
                    continue;
                }
            }
            else{
                continue;
            }
        }
        if ($group=='only_360') {
            return $this->redirect('?r=baholash/session/fil-all-session');
        }
        else{
            return $this->redirect('?r=baholash/session/fil-kpi-session');
        }
    }

    public function actionBackalltosessionnokpifact($session_id,$group)
    {
        $sessions = Session::find()->where(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->all();
        foreach ($sessions as $session) {
            $session->SESSION_ID = $session_id;
            $session->save(false); 
        }
        return $this->redirect('?r=baholash/session/fil-session');
    }
    public function actionBacktosessionforfilnokpifact($mfo,$session_id,$group)
    {
        $sessions = Session::find()->where(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->andWhere(['MFO'=>$mfo])->all();
        foreach ($sessions as $session) {            
            $session->SESSION_ID = $session_id;           
            $session->save(false); 
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionFilView($code,$group)
    {
        $period = Period::getPeriod();
        if(isset($_GET['oy'])&&$_GET['oy']!=date('n',strtotime($period))){
            $period = Period::getPeriodByOy($_GET['oy']);
        }
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)) {
            $code = $code;
        }
        else{
            $code = Zagr::getLocalByInps(Yii::$app->user->ID);
        }
        // var_dump($code);die;
        if ($period=='notfound') {
            $period = '2000-01-01';
        }
        $searchModel = new SessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(["assess_session.MFO" => $code])->andWhere(['assess_session.PERIOD'=>$period])->andWhere(['assess_session.GROUP_CODE'=>$group]); 
        //$dataProvider->query->where("");
        return $this->render('filview1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'code' => $code,
            'group' => $group,
            'period' => $period,
        ]);
    }

    public function actionFilialBahoAll()
    {
        $period = Period::getPeriod();
        if(isset($_GET['oy'])&&$_GET['oy']!=date('n',strtotime($period))){
            $period = Period::getPeriodByOy($_GET['oy']);
        }
        if ($period=='notfound') {
            $period = '2000-01-01';
        }
        $code = Zagr::getLocalByInps(Yii::$app->user->ID);
        $group = 'only_360';
        $searchModel = new SessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(["assess_session.MFO" => $code])->andWhere(['assess_session.PERIOD'=>$period])->andWhere(['assess_session.GROUP_CODE'=>$group]); 
        //$dataProvider->query->where("");
        return $this->render('co_user_view_all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'code' => $code,
            'group' => $group,
            'period' => $period,
        ]);
    }
    public function actionFilialBahoKpi()
    {
        $period = Period::getPeriod();
        if(isset($_GET['oy'])&&$_GET['oy']!=date('n',strtotime($period))){
            $period = Period::getPeriodByOy($_GET['oy']);
        }
        if ($period=='notfound') {
            $period = '2000-01-01';
        }
        $code = Zagr::getLocalByInps(Yii::$app->user->ID);
        $group = 'only_kpi';
        $searchModel = new SessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(["assess_session.MFO" => $code])->andWhere(['assess_session.PERIOD'=>$period])->andWhere(['assess_session.GROUP_CODE'=>$group]); 
        //$dataProvider->query->where("");
        return $this->render('co_user_view_kpi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'code' => $code,
            'group' => $group,
            'period' => $period,
        ]);
    }
    public function actionGetmodalajax()
    {
        $cbid = $_POST['cbid'];
        $group = $_POST['group'];
        $period = $_POST['period'];
        $now_period = Period::getPeriod();
        if ($group=='only_360') {
            $nuvarr = Fact::getNuvArrByCbidAll($cbid,$period);
        }
        else{
            $nuvarr = Fact::getNuvArrByCbidKpi($cbid,$period);
        }
        $emps = Zagr::find()->where(['in','INPS',$nuvarr])->orderBy(['NAME'=>SORT_ASC])->all();
        if (!$emps) {
            $emps = ZagrArch::find()->where(['in','INPS',$nuvarr])->andWhere(['PERIOD'=>$period])->orderBy(['NAME'=>SORT_ASC])->all();
        }
        $str='';
        $str.=Html::beginForm(['/baholash/session/delete-some'], 'post',['enctype' => 'multipart/form-data']);
        $str.="<table class='table table-bordered'>";
        $str.="<tr>";
        if ($period==$now_period&&(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))) {
            $str.="<th></th>";
        }
        $str.="<th>#</th>";
        $str.="<th>ФИО</th>";
        $str.="<th>Код</th>";
        $str.="<th>Булим</th>";
        $str.="<th>Лавозим</th>";
        $str.="<th>Бахо</th>";
        if ($period==$now_period&&(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))) {
            $str.="<th>Учириш</th>";
        }
        $str.="</tr>";
        $n = 1;
        if ($emps) {
            $str.=Html::input('hidden', 'lovcbid', $cbid);
            $str.=Html::input('hidden', 'group', $group);
            // ActiveForm::begin(['action'=>'/baholash/session/delete-some']);
            // $str.="<input type='hidden' name='lovcbid' value='".$cbid."'>
            //        <input type='hidden' name='group' value='".$group."'>";
            foreach ($emps as $emp) {
                $str.="<tr>";
                if ($period==$now_period&&(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))) {
                    $str.="<td>";
                    $str.=Html::input('checkbox', 'inps[]', $emp->INPS, ['id'=>'checkbox'.$emp->INPS,'class'=>'baholash','onchange'=>'btn('.$cbid.');']);
                    // <input type='checkbox' name='inps[]' value='".$emp->INPS."' class='form-control'>
                    $str.="</td>";
                }
                $str.="<td>".$n."</td>";
                $str.="<td>".$emp->NAME."</td>";
                $str.="<td>".$emp->CODE_DOLJ."</td>";
                $str.="<td>".$emp->BOLIM_NAME."</td>";
                $str.="<td>".$emp->LAVOZIM_NAME."</td>";
                $count = Fact::getOtsenkiColor($emp->INPS,$group,$period);
                if ($count>0) {
                    $style = "style='background:#d43f3a;'";
                }
                else{
                    $style = "style='background:#5cb85c;'";
                }
                $str.="<td ".$style.">".Fact::getOtsenkiLov($emp->INPS,$cbid,$group,$period)."</td>";
                if ($period==$now_period&&(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)))
                {
                    $str.="<td>".Html::a("Ўчириш", ['/baholash/session/deleteone','nuv'=>$emp->INPS,'lov'=>$cbid,'gr'=>$group], [
                                  'class' => 'btn btn-danger btn-sm',
                                  'style'=>'text-align:center',
                                  'title'=>'Ўчириш',
                                  'data' => [
                                      'confirm' => 'Ишончингиз комилми?',
                                      'method' => 'post',
                                  ],
                              ])."</td>";

                }
                $str.="</tr>";
                $n++;
            }
            // $form = true;
        }
        if ($n>1&&(AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))) {
            $str.="<tr>";
            $str.="<td colspan='8'>";
            // $str.="<button type='submit'  class='btn-warning btn-sm' />Ўчириш</button>";
            $str.=Html::submitButton('Ўчириш', ['class' => 'btn-warning btn-sm','disabled'=>true,'id'=>'delete'.$cbid,'data-confirm'=>'Ишончингиз комилми?']);
            // $str.="<input type='submit' value='Ўчириш' data-confirm='Ишончингиз комилми?' class='btn-warning btn-sm' />";
            // <a class='btn btn-warning btn-sm' data-confirm='Ишончингиз комилми?'>Ўчириш</a>
            $str.="</td>";
            $str.="</tr>";
            // ActiveForm::end();
        }
        $str.="</table>";
        $str.=Html::endForm();
        echo $str;
        exit;
    }
    public function actionGetmodalajax1()
    {
        $cbid = $_POST['cbid'];
        $group = $_POST['group'];
        // if ($group=='only_360') {
        //     $nuvarr = Fact::getNuvArrByCbidAll(Yii::$app->user->ID);
        // }
        // else{
        //     $nuvarr = Fact::getNuvArrByCbidKpi(Yii::$app->user->ID);
        // }
        $emps = Zagr::find()->where(['INPS'=>$cbid])->orderBy(['NAME'=>SORT_ASC])->all();
        $facts = Fact::find()->where(['NUV_ID'=>$cbid])->andWhere(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->andWhere(['LOV_ID'=>Yii::$app->user->ID])->orderBy(['POKAZ_CODE'=>SORT_ASC])->all();
        $str='';
        $str.="<table class='table table-bordered'>";
        $str.="<tr>";
        $str.="<th style='width:3%;'>#</th>";
        $str.="<th style='width:25%;'>ФИО</th>";
        $str.="<th style='width:30%;'>Критерий</th>";
        $str.="<th style='width:7%;'>Бахо</th>";
        $str.="<th style='width:30%;'>Изох</th>";
        $str.="</tr>";
        $n = 1;
        foreach ($facts as $fact) {
            $str.="<tr>";
            $str.="<td>".$n."</td>";
            $str.="<td>".Zagr::getName($fact->NUV_ID)."</td>";
            $str.="<td>".Zagr::getPokazName($fact->POKAZ_CODE)."</td>";
            $str.="<td>".$fact->VALUE."</td>";
            $str.="<td>".$fact->COMMENT."</td>";
            $str.="</tr>";
            $n++;
        }
        $str.="</table>";
        echo $str;
        exit;
    }
    public function actionDeleteone($nuv,$lov,$gr)
    {
        // if(!AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
        //     return $this->redirect('?r=site/index');
        // }
        $sql = "delete from assess_fact where LOV_ID='{$lov}' and NUV_ID='{$nuv}' and GROUP_CODE='{$gr}' and PERIOD='".Period::getPeriod()."'";
        Yii::$app->db->createCommand($sql)->execute();
        $mfo = Zagr::getLocalByInps($lov);
        if ($gr=='only_360') {
            return $this->redirect('?r=baholash/session/fil-view&code='.$mfo.'&group=only_360');
        }
        else{
            return $this->redirect('?r=baholash/session/fil-view&code='.$mfo.'&group=only_kpi');
        }
    }

    public function actionDeleteSome()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die;
        $period = Period::getPeriod();
        $inpss = $_POST['inps'];
        $lovcbid = $_POST['lovcbid'];
        $group = $_POST['group'];
        foreach ($inpss as $key => $inps) {
            Fact::find()->where(['LOV_ID'=>$lovcbid])->andWhere(['NUV_ID'=>$inps])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>$period])->one()->delete();
        }
        $mfo = Zagr::getLocalByInps($lovcbid);
        if ($group=='only_360') {
            return $this->redirect('?r=baholash/session/fil-view&code='.$mfo.'&group=only_360');
        }
        else{
            return $this->redirect('?r=baholash/session/fil-view&code='.$mfo.'&group=only_kpi');
        }
    }

    public function actionObnovitSessii($group)
    {
        $model = Session::find()->where(['PERIOD'=>Period::getPeriod()])->andWhere(['GROUP_CODE'=>$group])->orderBy(['MFO'=>SORT_ASC])->all();
        foreach ($model as $key) {
            $nuvarr_model = Fact::find()->select('NUV_ID')->where(['LOV_ID'=>$key->LOV_ID])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->distinct()->all();
            $nuv_arr = ArrayHelper::getColumn($nuvarr_model,'NUV_ID');
            $check = 0;
            foreach ($nuv_arr as $nuv) {
                $kpifact = Fact::find()->where(['LOV_ID'=>$key->LOV_ID])->andWhere(['NUV_ID'=>$nuv])->andWhere(['GROUP_CODE'=>$group])->andWhere(['PERIOD'=>Period::getPeriod()])->all();
                $i = 0;
                foreach ($kpifact as $fact) {
                    if (strlen($fact->VALUE)>0) {
                        continue;
                    }
                    else{
                        $i++;
                    }
                }
                $check = $check + $i;
            }
            if ($check>0) {
                if ($key->SESSION_ID=='2') {
                    $key->SESSION_ID = '1';
                    $key->save(false);
                }
                else{
                    continue;
                }
            }
            else{
                if ($key->SESSION_ID=='1') {
                    $key->SESSION_ID = '2';
                    $key->save(false);
                }
                else{
                    continue;
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
