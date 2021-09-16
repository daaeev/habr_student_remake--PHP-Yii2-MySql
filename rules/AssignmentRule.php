<?php

namespace app\rules;

use yii\rbac\Rule;
use app\models\User;

class AssignmentRule extends Rule
{
    public $name = 'AssignmentRule';

    public function execute($user_id, $item, $params)
    {
        $user = $user_id ? User::findIdentity($user_id) : null;
        if (!empty($user) && $user->status == 1) {
            return true;
        }
        return false;
    }
}