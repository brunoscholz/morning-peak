<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['validate'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'validate/<key:\w+>' => ['GET'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();
        //$actions['validate'] = ['GET'];
        return $actions;
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->userId = User::generateId();
            $model->salt = User::generateSalt();
            $model->password = User::hashPassword($model->password, $model->salt);
            $model->activation_key = User::generateActivationKey();
            $model->validation_key = User::generateValidationKey($model->activation_key, $model->email, $model->userId);
            $model->status = "AWT";

            $model->createdAt = date('y-m-d h:i:s');
            $model->updatedAt = date('y-m-d h:i:s');

            if($model->save())
                return $this->redirect(['view', 'id' => $model->userId]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
//http://admin.ondetem.com.br/user/validate?key=NQzx8v7RpOpanUFgzUlbdhzQfSBnG
    public function actionValidate($key)
    {
        $id = substr($key, 8);
        $realKey = substr($key, 0, 8);

        $model = $this->findModel($id);

        if($model->verifyKeys($realKey))
        {
            $model->status = "ATV";
            if($model->save())
            {
                if (!Yii::$app->session->getIsActive()) {
                    Yii::$app->session->open();
                }
                Yii::$app->session['userData'] = $model->userId;
                Yii::$app->getSession()->setFlash('success', 'Sua conta foi ativada! Termine seu cadastro para mais clientes te acharem.');
                Yii::$app->session->close();
                return $this->redirect(['seller/create']); //, 'userData'=>$model]
            }
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->userId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Essa página não existe!!!');
        }
    }
}
