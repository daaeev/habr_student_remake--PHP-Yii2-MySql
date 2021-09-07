<?php

namespace app\rules;

use app\models\User;
use yii\rbac\Rule;

class AdminPanelRule extends Rule 
{
    public $name = 'AdminPanelAccess';

    public function execute($user_id, $item, $params)
    {
        if (isset($user_id) && (User::findIdentity($user_id))->status != 0) {
            return true;
        }
        return false;
    }
}