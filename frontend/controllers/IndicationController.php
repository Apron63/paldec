<?php

namespace frontend\controllers;

use Yii;
use common\models\Indication;
use common\models\IndicationSearch;
use common\models\Counter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndicationController implements the CRUD actions for Indication model.
 */
class IndicationController extends Controller
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
        ];
    }

    /**
     * Lists all Indication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IndicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $counter = Counter::findOne(['id' => Yii::$app->request->get('id')]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'counter' => $counter,
        ]);
    }

    /**
     * Displays a single Indication model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Indication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($counter_id)
    {
        $model = new Indication();
        $model->counter_id = $counter_id;
        $model->date = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/indication/index', 'id' => $model->counter_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Indication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/indication/index', 'id' => $model->counter_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Indication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $tmp = $this->findModel($id);
        $tmp_id = $tmp->counter_id;
        $tmp->delete();
        return $this->redirect(['/indication/index', 'id' => $tmp_id]);
    }

    public function actionMassInput()
    {
        echo "Mass";
    }

    /**
     * Finds the Indication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Indication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Indication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
