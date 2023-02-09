<?php

namespace app\modules\baholash\controllers;

use Yii;
use app\modules\baholash\models\KpiCard;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Filials;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\KpiCardSearch;
use app\modules\baholash\models\Zagr;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KpiCardController implements the CRUD actions for KpiCard model.
 */
class KpiCardController extends Controller
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
     * Lists all KpiCard models.
     * @return mixed
     */
    public $layout = 'baho';
    public function actionIndex($bfdo1NGa1JkjfMn78t82dM17V)
    {
        $period = Period::getPeriod();
        if(isset($_GET['oy'])&&$_GET['oy']!=date('n',strtotime($period))){
            $period = Period::getPeriodByOy($_GET['oy']);
        }
        if ($period=='notfound') {
            $period = '2000-01-01';
        }
        $searchModel = new KpiCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['INPS'=>$bfdo1NGa1JkjfMn78t82dM17V])->andWhere(['PERIOD'=>$period])->orderBy(['ORD'=>SORT_ASC]);
        $zagr = Zagr::find()->where(['INPS'=>$bfdo1NGa1JkjfMn78t82dM17V])->one();
        $name_lavozim = ($zagr ? "<b>".$zagr->NAME."</b> - ". Filials::getName(substr($zagr->LOCAL_CODE,0,3)) ." ".$zagr->BOLIM_NAME.' '.$zagr->LAVOZIM_NAME : 'Topilmadi');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'period'=>$period,
            'name_lavozim'=>$name_lavozim,
            'bfdo1NGa1JkjfMn78t82dM17V'=>$bfdo1NGa1JkjfMn78t82dM17V
        ]);
    }

    public function actionAll()
    {
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)) {
            $searchModel = new KpiCardSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->orderBy(['PERIOD'=>SORT_DESC,'INPS'=>SORT_ASC,'ORD'=>SORT_ASC]);
            return $this->render('all', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]);
        }
        else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMyKpi()
    {
        $period = Period::getPeriod();
        if(isset($_GET['oy'])&&$_GET['oy']!=date('n',strtotime($period))){
            $period = Period::getPeriodByOy($_GET['oy']);
        }
        if ($period=='notfound') {
            $period = '2000-01-01';
        }
        $searchModel = new KpiCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['INPS'=>Yii::$app->user->ID])->andWhere(['PERIOD'=>$period])->orderBy(['ORD'=>SORT_ASC]);
        return $this->render('my-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'period'=>$period
        ]);
    }

    /**
     * Displays a single KpiCard model.
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
     * Creates a new KpiCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KpiCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KpiCard model.
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
     * Deletes an existing KpiCard model.
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
     * Finds the KpiCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KpiCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KpiCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
