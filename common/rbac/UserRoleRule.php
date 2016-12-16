<?php 

namespace common\rbac; 

use yii\rbac\Rule;
/**  
 * Checks if user role matches user passed via params  
 */

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    
    public function execute($user, $item, $params)
    {
        //check the role from table user
        if(isset(\Yii::$app->user->identity->role))
            $role = \Yii::$app->user->identity->role;
    	else
    	     return false;
     
        if ($item->name === 'admin') {
            return $role == 'admin';
        } elseif ($item->name === 'salesman') {
            return $role == 'admin' || $role == 'salesman'; //editor is a child of admin
        }	elseif ($item->name === 'regular') {
            //user is a child of editor and admin, if we have no role defined this is also the default role
            return $role == 'admin' || $role == 'salesman' || $role == 'user'; || $role == NULL;
        } else {
            return false;
        }
    }
}