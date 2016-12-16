<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //remove previous rbac

        //CREATE RULES

        // add "isOwner" rule for the profiles
        $ruleOwner = new \common\rbac\OwnerRule;
        $auth->add($ruleOwner);

        // add "isAuthor" rule for the offers
        $ruleAuthor = new \common\rbac\AuthorRule;
        $auth->add($ruleAuthor);


        //CREATE PERMISSIONS

        // add "createOffer" permission
        $createOffer = $auth->createPermission('createOffer');
        $createOffer->description = 'Criar uma oferta';
        $auth->add($createOffer);

        // add "updateOffer" permission
        $updateOffer = $auth->createPermission('updateOffer');
        $updateOffer->description = 'Modificar uma oferta';
        $auth->add($updateOffer);

        // add "updateProfile" permission
        $updateProfile = $auth->createPermission('updateProfile');
        $updateProfile->description = 'Editar Perfis de Usuário';
        $auth->add($updateProfile);

        // add the "updateOwnProfile" permission and associate the rule with it.
        $updateOwnProfile = $auth->createPermission('updateOwnProfile');
        $updateOwnProfile->description = 'Modificar perfil próprio'; // either buyer or seller
        $updateOwnProfile->ruleName = $ruleOwner->name;
        $auth->add($updateOwnProfile);
        // "updateOwnProfile" will be used from "updateProfile"
        $auth->addChild($updateOwnProfile, $updateProfile);

        // add the "updateOwnOffer" permission and associate the rule with it.
        $updateOwnOffer = $auth->createPermission('updateOwnOffer');
        $updateOwnOffer->description = 'Modificar oferta própria';
        $updateOwnOffer->ruleName = $ruleAuthor->name;
        $auth->add($updateOwnOffer);
        // "updateOwnOffer" will be used from "updateOffer"
        $auth->addChild($updateOwnOffer, $updateOffer);

        // createReview (update) (not in self owned offer)
        // createComment (update) (delete in if 'my' offer, as well)
        // createFollow (update)
        // createFavorite (update)
        // createVendor
        // $removeReview

        //CREATE ROLES

        // cretes and updates (deletes) reviews, comments, favorites, follows, etc
        // add "user" role
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $updateOwnProfile);
        //$auth->addChild($user, $addReview);
        //$auth->addChild($user, $removeOwnReview);
        //$auth->addChild($user, $addComment);
        //$auth->addChild($user, $removeOwnComment);
        //$auth->addChild($user, $addFollow);
        //$auth->addChild($user, $removeOwnFollow);
        //$auth->addChild($user, $addFavorite);
        //$auth->addChild($user, $removeOwnFavorite);

        // creates vendors
        // add "salesman" role
        $salesman = $auth->createRole('salesman');
        $auth->add($salesman);
        $auth->addChild($salesman, $user);
        //$auth->addChild($salesman, $createVendor);

        // add "vendor" role and give this role the "createOffer" permission
        $vendor = $auth->createRole('vendor');
        $auth->add($vendor);
        $auth->addChild($vendor, $createOffer);
        $auth->addChild($vendor, $updateOwnOffer);
        //$auth->addChild($user, $removeReviews); in my offer
        //$auth->addChild($user, $removeComments); in my offer
        $auth->addChild($vendor, $user);

        // add "moderator" role and give this role almost all permissions
        // or make his decisions (dangerous ones) to be validated by an admin
        // $auth->addChild($moderator, $user);
        // $auth->addChild($moderator, $salesman);
        // $auth->addChild($moderator, $vendor);

        // add "admin" role and give this role all permissions
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateOffer);
        $auth->addChild($admin, $updateProfile);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $salesman);
        $auth->addChild($admin, $vendor);

        // Assign roles to users. zZN6prD6rzxEhg8sDQz1j is an ID returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 'zZN6prD6rzxEhg8sDQz1j');
    }
}

/*
$auth = \Yii::$app->authManager;
$authorRole = $auth->getRole('author');
$auth->assign($authorRole, $user->getId());
*/

/*
if(\Yii::$app->user->can('createUser')){
     //call view with form to create users
}else{
     //call view telling the users that can't create users
}
*/