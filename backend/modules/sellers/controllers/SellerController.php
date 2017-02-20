<?php

namespace backend\modules\sellers\controllers;

use Yii;
use backend\models\User;
use common\models\Seller;
use backend\modules\sellers\models\SellerSearch;
use backend\modules\sellers\models\form\CompanyForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class SellerController extends Controller
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
     * Lists all Seller models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SellerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList() {}

    /**
     * Displays a single Seller model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('@common/views/profiles/seller-profile', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays all Seller models for a given user.
     * @param string $id
     * @return mixed
     */
    public function actionViewAll($id)
    {
        $loggedUser = Yii::$app->user->identity;
        $models = Yii::$app->user->identity->sellers;
        $user = User::findById($id);

        if(($user->userId !== $loggedUser->userId) && Yii::$app->user->can('admin')) {
            $models = $user->sellers;
        }


        return $this->render('all-sellers', [
            'model' => $models,
        ]);
    }

    /**
     * Creates a new Seller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $params = Yii::$app->request->post();
        $companyForm = new CompanyForm();
        $companyForm->user = $this->findUserModel(isset($params['userId']) ? $params['userId'] : Yii::$app->user->identity->userId);
        $companyForm->seller = new Seller();
        $companyForm->setAttributes($params);

        if ($params && $companyForm->validate()) {
            $companyForm->picture->imageCover = UploadedFile::getInstance($companyForm->picture, 'imageCover');
            $companyForm->picture->imageThumb = UploadedFile::getInstance($companyForm->picture, 'imageThumb');
            $companyForm->picture->status = 'ACT';

            if($companyForm->save()) {
                Yii::$app->getSession()->setFlash('success', 'Empresa cadastrada com sucesso.');
                return $this->redirect(['seller/view', 'id' => $companyForm->seller->sellerId]);
            }
        }

        return $this->render('create', ['model' => $companyForm]);
    }

    /**
     * Updates an existing Seller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->sellerId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Seller model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Seller model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Seller the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seller::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserModel($id)
    {
        if (($model = \backend\models\User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function CreditCoin()
    {
        $params = Yii::$app->request->post();
        if(isset($params['post'])) {
            $test = ['time' => date('H:i:s')];
            
        } else {
            $test = ['time' => 'undefined'];
            
        }

        // return Json    
        return \yii\helpers\Json::encode($test);
        //return $this->render('index', ['time' => date('H:i:s')]);
    }
}
