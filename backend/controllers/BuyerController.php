<?php

namespace backend\controllers;

use Yii;
use common\models\Buyer;
use backend\models\BuyerSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//use yii\web\UploadedFile;

/**
 * BuyerController implements the CRUD actions for Buyer model.
 */
class BuyerController extends Controller
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
     * Lists all Buyer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuyerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRoleIndex($role)
    {
        $searchModel = new BuyerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query
            ->join('JOIN', 'tbl_user', 'tbl_user.buyerId = tbl_buyer.buyerId')  
            ->where(['tbl_user.role' => $role]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buyer model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('@common/views/profiles/user-profile', [
            'model' => $this->findUserModel($id),
        ]);
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    /**
     * Creates a new Buyer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Buyer();

        $loggedUser = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->buyerId = \backend\models\User::generateId();
            $model->userId = $loggedUser->userId;
            $model->status = 'ATV';
            // dob select from Date model
            
            // $model->sku = \backend\models\User::getToken(12);

            $picModel = new \backend\models\Picture();
            $picModel->pictureId = \backend\models\User::generateId();
            $model->pictureId = $picModel->pictureId;

            $picModel->imageCover = UploadedFile::getInstance($model, 'imageCover');
            $picModel->imageThumb = UploadedFile::getInstance($model, 'imageThumb');
            $picModel->status = 'ATV';


            if ($picModel->upload()) {
                $picModel->imageCover = null;
                $picModel->imageThumb = null;
            }

            if($model->save() && $picModel->save())
                return $this->redirect(['view', 'id' => $model->buyerId]);


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Buyer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->buyerId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Buyer model.
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
     * Finds the Buyer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Buyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buyer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserModel($id)
    {
        if (($model = User::find()->where(['like binary', 'buyerId', $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
