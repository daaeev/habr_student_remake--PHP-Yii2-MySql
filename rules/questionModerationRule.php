<?php

namespace app\rules;

use yii\rbac\Rule;
use app\models\User;

class questionModerationRule extends Rule
{
    public $name = 'questionModerationRule';

    public function execute($user_id, $item, $params)
    {
        $user = $user_id ? User::findIdentity($user_id) : null;
        if (!empty($user) && $user->status > 0 && $user->status < 3) {
            return true;
        }
        return false;
    }
}