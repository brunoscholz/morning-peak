<?php

namespace backend\controllers;

use Yii;
use common\models\Offer;
use backend\models\OfferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
     * Creates a new Offer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Offer();
        $modelItem = new \backend\models\Item();
        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $modelItem->load($postData)) {
            $modelItem->itemId = \backend\models\User::generateId();
            $modelItem->sku = \backend\models\User::getToken(12);
            $modelItem->status = 'PEN';

            $picModel = new \backend\models\Picture();
            $picModel->pictureId = \backend\models\User::generateId();

            $picModel->imageCover = UploadedFile::getInstance($model, 'imageCover');
            $picModel->imageThumb = UploadedFile::getInstance($model, 'imageThumb');
            $picModel->status = 'ATV';

            if ($picModel->upload()) {
                $picModel->imageCover = null;
                $picModel->imageThumb = null;
            }

            $model->offerId = \backend\models\User::generateId();
            $model->itemId = $modelItem->itemId;
            $model->pictureId = $picModel->pictureId;
            $model->sellerId = 'vW8wrgSIKukU78XxxhgGs';

            if($modelItem->validate() && $picModel->validate() && $model->validate()) {
                if($modelItem->save() && $picModel->save() && $model->save())
                    return $this->redirect(['view', 'id' => $model->offerId]);
            }
            else {
                print_r($model->getErrors());
                print_r($picModel->getErrors());
                print_r($modelItem->getErrors());
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
