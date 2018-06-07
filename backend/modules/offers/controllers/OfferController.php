<?php

namespace backend\modules\offers\controllers;

use Yii;
use common\models\User;
use common\models\Offer;
use backend\modules\offers\models\OfferSearch;
use backend\modules\offers\models\form\OfferForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
//use yii\helpers\ArrayHelper;

/**
 * OfferController implements the CRUD actions for Offer model.
 */
class OfferController extends Controller
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
     * Lists all Offer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Offer model.
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
     * Displays all Offer models for a given user.
     * @param string $id
     * @return mixed
     */
    public function actionViewAll($id)
    {
        $loggedUser = Yii::$app->user->identity;
        $user = User::findById($id);

        if(($user->userId !== $loggedUser->userId) && Yii::$app->user->can('admin')) {
            $loggedUser = $user;
        }

        $searchModel = new OfferSearch();
        $dataProvider = $searchModel->search([]);

        foreach ($loggedUser->sellers as $seller)
            $dataProvider->query->orWhere(['like binary', 'sellerId', $seller->sellerId]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Offer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $params = Yii::$app->request->post();
        $offerForm = new OfferForm();
        //$offerForm->user = $this->findUserModel(isset($params['userId']) ? $params['userId'] : Yii::$app->user->identity->userId);
        $offerForm->seller = isset($params['OfferForm']['sellerId']) ? $params['OfferForm']['sellerId'] : '';
        $offerForm->offer = new OfferSearch();
        $offerForm->setAttributes($params);

        if ($params && $offerForm->validate()) {
            // required?
            $offerForm->picture->imageCover = UploadedFile::getInstance($offerForm->picture, 'imageCover');
            //$offerForm->picture->imageThumb = UploadedFile::getInstance($offerForm->picture, 'imageThumb');
            $offerForm->picture->status = 'ATV';

            if($offerForm->save()) {
                Yii::$app->getSession()->setFlash('success', 'Oferta cadastrada com sucesso.');
                return $this->redirect(['offer/view', 'id' => $offerForm->offer->offerId]);
            }
        }

        return $this->render('create', ['model' => $offerForm]);
    }

    /**
     * Updates an existing Offer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        /*var_dump(Yii::$app->request->post());
        die();*/

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->offerId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Offer model.
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
     * Finds the Offer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Offer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Offer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
