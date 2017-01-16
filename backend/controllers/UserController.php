<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\form\ProfileForm;
use backend\models\form\RegisterForm;
use backend\models\User;
use common\models\Seller;
// use common\models\User as UserModel;
use backend\components\Utils;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $params = Yii::$app->request->post();
        $profileForm = new ProfileForm();
        $profileForm->user = new User();
        $profileForm->setAttributes($params);

        if ($params && $profileForm->validate()) {
            $profileForm->user->email = strtolower($profileForm->user->email);

            $check = User::findByUsername($profileForm->user->email);
            if(!is_null($check))
            {
                Yii::$app->session->setFlash('error', "Usuário já existe");
                return $this->render('create', [
                    'model' => $profileForm,
                ]);
            }

            $profileForm->picture->imageCover = UploadedFile::getInstance($profileForm->picture, 'imageCover');
            $profileForm->picture->imageThumb = UploadedFile::getInstance($profileForm->picture, 'imageThumb');
            $profileForm->picture->status = 'ATV';

            if($profileForm->save()) {
                Yii::$app->getSession()->setFlash('success', 'O novo usuário foi cadastrado.');
                return $this->redirect(['buyer/view', 'id' => $profileForm->buyer->buyerId]);
            }
        }

        return $this->render('create', ['model' => $profileForm]);
    }
            

    public function actionRegister($id)
    {
        $params = Yii::$app->request->post();

        $companyForm = new RegisterForm();
        $seller = Seller::findById($id);
        $user = $this->findModel($seller->userId);
        $companyForm->user = $user;
        $companyForm->buyer = $user->buyer;
        $companyForm->buyerPicture = $user->buyer->picture;

        $companyForm->seller = $seller;
        $companyForm->picture = $seller->picture;
        $companyForm->billingAddress = $seller->billingAddress;
        
        //$companyForm->setAttributes($params);
        if ($companyForm->loadAll($params)) {
            if($companyForm->save()) {
                Yii::$app->getSession()->setFlash('success', 'Empresa cadastrada com sucesso.');
                //return $this->redirect(['seller/view', 'id' => $companyForm->seller->sellerId]);
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('register', ['model' => $companyForm]);
    }

    //http://admin.ondetem-gn.com.br/user/validate?key=cDBwVEZ3VHliY3Q1SVQ3V3ZrUzZWTWo3WWVMSlR2WG5ReFNVRHE4cFFR
    public function actionValidate($key)
    {
        $selector = substr($key, 0, 12);
        $authenticator = substr($key, 12);

        $model = Seller::findByActivationKey($selector);

        if($model->verifyKeys($authenticator))
        {
            $model->status = "REG";
            if($model->save())
            {
                /*if (!Yii::$app->session->getIsActive()) {
                    Yii::$app->session->open();
                }
                Yii::$app->session['userData'] = $model->userId;
                Yii::$app->getSession()->setFlash('success', 'Sua conta foi ativada! Termine seu cadastro para mais clientes te acharem.');
                Yii::$app->session->close();*/
                return $this->redirect(['register', 'id' => $model->sellerId]); //, 'userData'=>$model]
            }
        }
        else
            var_dump(false); // 404
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateOld($id)
    {
        $params = Yii::$app->request->post();
        var_dump($params);
        $model = $this->findModel($id);
        $buyer = $model->buyer;

        // $model->scenario = 'update';
        // $buyer->scenario = 'update';

        if ($buyer->load($params) && $buyer->validate())
        {
            if(!empty($params['User']['checkPassword']) && 
                !empty($params['User']['newPassword']) && 
                !empty($params['User']['confirmPassword']))
            {
                if($model->validatePassword($params['User']['checkPassword']))
                {
                    if($params['User']['confirmPassword'] == $params['User']['newPassword'])
                    {
                        $salt = Utils::generateSalt();
                        $model->salt = $salt;
                        $model->password = User::hashPassword($params['User']['newPassword'], $salt);
                    }
                    else
                    {
                        // senhas diferentes
                        Yii::$app->session->setFlash('error', "A nova senha deve ser confirmada corretamente");
                        return $this->redirect(['buyer/view', 'id' => $model->buyer->buyerId]);
                    }
                }
                else
                {
                    // senha atual incorreta
                    Yii::$app->session->setFlash('error', "Senha incorreta");
                    return $this->redirect(['buyer/view', 'id' => $model->buyer->buyerId]);
                }
            }

            $picture = $model->buyer->picture;
            $coverImg = UploadedFile::getInstance($picture, 'imageCover');
            $thumbImg = UploadedFile::getInstance($picture, 'imageThumb');

            var_dump($thumbImg);
            var_dump($coverImg);
            var_dump($model);
            die();

            // verify if <> than last one
            // probrably a hidden field changed by upload function
            if(!is_null($coverImg) || !is_null($thumbImg))
            {
                $picture->imageCover = UploadedFile::getInstance($picture, 'cover');
                $picture->imageThumb = UploadedFile::getInstance($picture, 'thumb');
                $picture->status = 'ATV';

                if ($picture->upload()) {
                    $picture->imageCover = null;
                    $picture->imageThumb = null;
                    $picture->save();
                }
                else
                {
                    Yii::$app->session->setFlash('error', "Problemas fazendo upload da foto");
                    return $this->redirect(['buyer/view', 'id' => $model->buyer->buyerId]);
                }
            }

            $buyer->save();
            $model->save();
            return $this->redirect(['buyer/view', 'id' => $buyer->buyerId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $params = Yii::$app->request->post();
        $profileForm = new ProfileForm();
        $profileForm->user = $this->findModel($id);
        $profileForm->setAttributes($params);
        $profileForm->attributes = $params['ProfileForm'];

        if ($params && $profileForm->validate()) {
            $profileForm->user->email = strtolower($profileForm->user->email);

            $profileForm->picture->imageCover = UploadedFile::getInstance($profileForm->picture, 'imageCover');
            $profileForm->picture->imageThumb = UploadedFile::getInstance($profileForm->picture, 'imageThumb');

            if($profileForm->save()) {
                Yii::$app->getSession()->setFlash('success', 'As informações do usuário foram atualizadas.');
                return $this->redirect(['buyer/view', 'id' => $profileForm->buyer->buyerId]);
            }
        }

        return $this->render('update', ['model' => $profileForm]);
    }

    public function validatePassword($email, $pass)
    {
        $user = User::findByUsername($email);

        if (!$user || !$user->validatePassword($pass)) {
            $this->addError('password', 'Senha incorreta.');
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
