<?php

namespace backend\controllers;

use Yii;
use backend\models\Seller;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SellerController implements the CRUD actions for Seller model.
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
        $dataProvider = new ActiveDataProvider([
            'query' => Seller::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seller model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Seller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seller();

        $loggedUser = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sellerId = \backend\models\User::generateId();
            $model->userId = $loggedUser->userId;

            $payList = Yii::$app->request->post()['Seller']['paymentOptions'];
            $model->paymentOptions = implode(",", $payList);
            $model->status = 'ATV';

            $picModel = new \backend\models\Picture();
            $picModel->pictureId = \backend\models\User::generateId();
            $model->pictureId = $picModel->pictureId;

            $picModel->imageCover = UploadedFile::getInstance($model, 'imageCover');
            $picModel->imageThumb = UploadedFile::getInstance($model, 'imageThumb');
            $picModel->status = 'ATV';


            if ($picModel->upload())
                $picModel->imageCover = null;
                $picModel->imageThumb = null;

            if($model->save() && $picModel->save())
                return $this->redirect(['view', 'id' => $model->sellerId]);


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

            /*if (isset(Yii::$app->session['userData']))
            {
                $id = Yii::$app->session['userData'];
                $model->userId = $id;
            }*/
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
