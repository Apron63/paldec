<?php

namespace frontend\controllers;

use Yii;
use common\models\Company;
use common\models\CompanySearch;
use common\models\Counter;
use common\models\CounterSearch;
use common\models\CounterModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CounterController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Counter();
        $model->company_id = Yii::$app->session->get('companyId');
        $model->date_verification = time();
        $model->date_made = $model->date_verification;
        $model->date_set = $model->date_verification;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['/']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);

        }
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['/']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Counter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddModelFromCreate($company_id)
    {
        $model = new CounterModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/counter/create', 'company-id' => $company_id]);
        } else {
            return $this->render('add-model', [
                'model' => $model,
            ]);
        }
    }

    public function actionAddModelFromUpdate($id)
    {
        $model = new CounterModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/counter/update', 'id' => $id]);
        } else {
            return $this->render('add-model', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetList($id)
    {
        if(isset($id)) {
            Yii::$app->session->set('companyId', $id);
            $name = Company::findOne(['id' => $id])->short_name;
        }
        $searchModelA = new CounterSearch();
        $dataProviderA = $searchModelA->search(Yii::$app->request->queryParams);
        return $this->renderAjax('list', [
            'name' => $name,
            'searchModelA' => $searchModelA,
            'dataProviderA' => $dataProviderA,
        ]);
    }

    public function actionGetCompanyId()
    {
        $i = Yii::$app->session->get('companyId');
        if(isset($i)) {
            return $i;
        } else {
            return 0;
        }
    }

    public function actionGetArhStatus()
    {
        $st = Yii::$app->session->get('showArh');
        if (isset($st)) {
            return $st;
        } else {
            return false;
        }
    }

    public function actionSetArhStatus($status)
    {
        Yii::$app->session->set('showArh', $status);
    }
}
