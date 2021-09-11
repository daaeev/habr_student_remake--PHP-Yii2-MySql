<?php

namespace app\components;

use Yii;
use app\models\User;
use yii\helpers\ArrayHelper;

class RoleHelper 
{
    /* 
       Returns a standardized array of all roles
    */
    public static function getRoles(): array
    {
        return ArrayHelper::map(Yii::$app->authManager->roles, 'name', 'name');
    }

    /*
       Defining and setting the status field in the user table
    */
    public static function setUserStatus(User $user, array $roles = null, string $form_role = null)
    {
        /*
           If an array of roles is passed, then we define the status and assign,
           otherwise we assign the status of an ordinary user
        */
        if (!empty($roles)) {
            $status = 0;
            foreach ($roles as $role) {
                if ($form_role == $role) {
                    $user->status = $status;
                    $user->save(false);
                    
                    return;
                }

                $status++;
            }
        }
    }

    /* 
       Assigning a role to a user
    */
    public static function setUserRole(string $role, int $user_id)
    {
        Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role), $user_id);
    }
}