<?php

namespace app\modules\baholash\controllers;

use Yii;
use app\modules\baholash\models\Relation;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\Filials;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\RelPokaz;
use app\modules\baholash\models\RelationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RelationController implements the CRUD actions for Relation model.
 */
class RelationController extends Controller
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
     * Lists all Relation models.
     * @return mixed
     */
    public $layout = 'baho';
    public function actionIndex()
    {
        $searchModel = new RelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Relation model.
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
     * Creates a new Relation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Relation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Relation model.
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
     * Deletes an existing Relation model.
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
     * Finds the Relation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Relation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Relation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBahoStart()
    {
        if(!AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
            return $this->redirect('?r=site/index');
        }
        set_time_limit(1000);
        $group = $_POST['groups'];
        $period = Period::getPeriod();
        //////////////////////-------INPS---------//////////////////////////////////////////////////////////
        $relations_inps = Relation::find()->where(['GROUP_CODE'=>$group])->andWhere('length(nuv_dolj_code)>4')->all();
        foreach ($relations_inps as $relation_inps) {
            $nuv_emp = Zagr::find()->where(['INPS'=>$relation_inps->NUV_DOLJ_CODE])->one();
            if ($nuv_emp) {
                $krit_rels = RelPokaz::find()->where(['REL_ID'=>$relation_inps->ID])->all();
                foreach ($krit_rels as $krit_rel) {
                    $lov_inps = $relation_inps->LOV_DOLJ_CODE1;
                    if (strlen($lov_inps)<=4) {
                        $lov_inps = $relation_inps->LOV_DOLJ_CODE2;
                        if (strlen($lov_inps)<=4) {
                            $lov_inps = $relation_inps->LOV_DOLJ_CODE3;
                            if (strlen($lov_inps)<=4) {
                                $lov_inps = 'not_found_inps';
                            }
                            else{
                                $lov_inps = $lov_inps;
                            }
                        }
                        else{
                            $lov_inps = $lov_inps;
                        }
                    }
                    else{
                        $lov_inps = $lov_inps;
                    }
                    $fact = Fact::find()->where(['NUV_ID'=>$nuv_emp->INPS])->andWhere(['POKAZ_CODE'=>$krit_rel->POKAZ_CODE])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$relation_inps->GROUP_CODE])->one();
                    if (!$fact) {
                        $model = new Fact;
                        $model->GROUP_CODE = $relation_inps->GROUP_CODE;
                        $model->LOV_ID = $lov_inps;
                        $model->NUV_ID = $nuv_emp->INPS;
                        $model->POKAZ_CODE = $krit_rel->POKAZ_CODE;
                        $model->PERIOD = $period;
                        $model->save(false);
                    }
                }
            }
            else{
                continue;
            }
        }

        //////////////////////-------END INPS---------//////////////////////////////////////////////////////
        //////////////////////-------CODE_DOLJ---------//////////////////////////////////////////////////////
        $relations = Relation::find()->where(['GROUP_CODE'=>$group])->andWhere('length(nuv_dolj_code)<=4')->all();
        $arr = [];
        foreach ($relations as $relation) {
            // $filials = Filials::find()->orderBy(['MFO'=>SORT_ASC])->all();
            $filials = Zagr::getAllLocals();
            foreach ($filials as $local_code => $fil_local_code) {
                if (strlen($relation->LOV_DOLJ_CODE1)>0&&substr($relation->LOV_DOLJ_CODE1, 0,1)=='+') {
                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>substr($relation->LOV_DOLJ_CODE1, 1)])->one();
                    $has_plus = 1;
                }
                else{
                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE1])->andWhere(['LOCAL_CODE'=>$local_code])->one();
                    $has_plus = 0;
                }
                if ($has_lov) {
                    $lov_dolj = $has_lov->CODE_DOLJ;
                    $has_plus = $has_plus;
                }
                else{
                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE1])->andWhere(['LOCAL_CODE'=>$fil_local_code])->one();
                    if ($has_lov) {
                        $lov_dolj = $has_lov->CODE_DOLJ;
                        $has_plus = $has_plus;
                    }
                    else{
                        if (strlen($relation->LOV_DOLJ_CODE2)>0&&substr($relation->LOV_DOLJ_CODE2, 0,1)=='+') {
                            $has_lov = Zagr::find()->where(['CODE_DOLJ'=>substr($relation->LOV_DOLJ_CODE2, 1)])->one();
                            $has_plus = 1;
                        }
                        else{
                            $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE2])->andWhere(['LOCAL_CODE'=>$local_code])->one();
                            $has_plus = 0;
                        }
                        if ($has_lov) {
                            $lov_dolj = $has_lov->CODE_DOLJ;
                            $has_plus = $has_plus;
                        }
                        else{
                            $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE2])->andWhere(['LOCAL_CODE'=>$fil_local_code])->one();
                            if ($has_lov) {
                                $lov_dolj = $has_lov->CODE_DOLJ;
                                $has_plus = $has_plus;
                            }
                            else{
                                if (strlen($relation->LOV_DOLJ_CODE3)>0&&substr($relation->LOV_DOLJ_CODE3, 0,1)=='+') {
                                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>substr($relation->LOV_DOLJ_CODE3, 1)])->one();
                                    $has_plus = 1;
                                }
                                else{
                                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE3])->andWhere(['LOCAL_CODE'=>$local_code])->one();
                                    $has_plus = 0;
                                }
                                if ($has_lov) {
                                    $lov_dolj = $has_lov->CODE_DOLJ;
                                    $has_plus = $has_plus;
                                }
                                else{
                                    $has_lov = Zagr::find()->where(['CODE_DOLJ'=>$relation->LOV_DOLJ_CODE3])->andWhere(['LOCAL_CODE'=>$fil_local_code])->one();
                                    if ($has_lov) {
                                        $lov_dolj = $has_lov->CODE_DOLJ;
                                        $has_plus = $has_plus;
                                    }
                                    else{
                                        $lov_dolj = 'not_found';
                                        $has_plus = $has_plus;
                                    }
                                }
                            }
                        }
                    }
                }
                // echo "<pre>";
                // print_r($has_lov);
                // echo "</pre>";die;
                if ($has_plus==1) {
                    $lov_emp = Zagr::find()->where(['CODE_DOLJ'=>$lov_dolj])->one();
                }
                else{
                    $lov_emp = Zagr::find()->where(['CODE_DOLJ'=>$lov_dolj])->andWhere(['LOCAL_CODE'=>$local_code])->one();
                    if (!$lov_emp) {
                        $lov_emp = Zagr::find()->where(['CODE_DOLJ'=>$lov_dolj])->andWhere(['LOCAL_CODE'=>$fil_local_code])->one();
                    }
                }
                if ($lov_emp) {
                    $lov_id = $lov_emp->INPS;
                }
                else{
                    $lov_id = 'not_found_inps';
                }
                $nuv_emps = Zagr::find()->where(['CODE_DOLJ'=>$relation->NUV_DOLJ_CODE])->andWhere(['LOCAL_CODE'=>$local_code])->all();
                foreach ($nuv_emps as $nuv_emp) {
                    $krit_rels = RelPokaz::find()->where(['REL_ID'=>$relation->ID])->all();
                    foreach ($krit_rels as $krit_rel) {
                        $fact = Fact::find()->where(['NUV_ID'=>$nuv_emp->INPS])->andWhere(['POKAZ_CODE'=>$krit_rel->POKAZ_CODE])->andWhere(['PERIOD'=>$period])->andWhere(['GROUP_CODE'=>$relation->GROUP_CODE])->one();
                        if (!$fact) {
                            $model = new Fact;
                            $model->GROUP_CODE = $relation->GROUP_CODE;
                            $model->LOV_ID = $lov_id;
                            $model->NUV_ID = $nuv_emp->INPS;
                            $model->POKAZ_CODE = $krit_rel->POKAZ_CODE;
                            $model->PERIOD = $period;
                            $model->save(false);
                        }
                        // $arr[] = ['LOV_DOLJ'=>$lov_dolj,'LOV_ID'=>$lov_id,'NUV_ID'=>$nuv_emp->INPS,'POKAZ_CODE'=>$krit_rel->POKAZ_CODE,'PERIOD'=>$period,'HAS_PLUS'=>$has_plus];
                    }
                }
            }
        }
        //////////////////////-------END CODE_DOLJ---------//////////////////////////////////////////////////////

        return $this->redirect(Yii::$app->request->referrer);
    }
}
