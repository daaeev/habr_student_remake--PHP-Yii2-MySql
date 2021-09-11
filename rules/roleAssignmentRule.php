<?php

namespace app\rules;

use yii\rbac\Rule;
use app\models\User;

class roleAssignmentRule extends Rule
{
    public $name = 'roleAssignmentRule';

    public function execute($user_id, $item, $params)
    {
        $user = $user_id ? User::findIdentity($user_id) : null;
        if (!empty($user) && $user->status == 1) {
            return true;
        }
        return false;
    }
}