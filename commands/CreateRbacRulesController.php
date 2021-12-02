<?php

namespace app\commands;

use app\rules\AdminPanelRule;
use app\rules\AssignmentRule;
use app\rules\questionModerationRule;
use Yii;
use yii\console\Controller;

class CreateRbacRulesController extends Controller
{
    public function actionCreateRoles()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole('0 - user');
        $user->description = 'Обычный пользователь';
        $auth->add($user);

        $moderator = $auth->createRole('2 - moderator');
        $moderator->description = 'Модератор - проверяет корректность заданных вопросов';
        $auth->add($moderator);

        $admin = $auth->createRole('1 - admin');
        $admin->description = 'Админ - Задаёт роли другим пользователям';
        $auth->add($admin);

        $banned = $auth->createRole('3 - banned');
        $banned->description = 'Забаненый пользователь';
        $auth->add($banned);
    }

    public function actionCreatePermissions()
    {
        $auth = Yii::$app->authManager;

        $adminPanelRule = new AdminPanelRule();
        $auth->add($adminPanelRule);

        $adminPanel = $auth->createPermission('adminPanel');
        $adminPanel->description = 'Access to the admin panel';
        $adminPanel->ruleName = $adminPanelRule->name;
        $auth->add($adminPanel);


        $assignmentRule = new AssignmentRule();
        $auth->add($assignmentRule);

        $assignment = $auth->createPermission('assignment');
        $assignment->description = 'Ability to assign roles to users';
        $assignment->ruleName = $assignmentRule->name;
        $auth->add($assignment);


        $questionRule = new questionModerationRule();
        $auth->add($questionRule);

        $moderation = $auth->createPermission('questionModeration');
        $moderation->description = 'Checking the question for correctness';
        $moderation->ruleName = $questionRule->name;
        $auth->add($moderation);
    }

    public function actionCreateChildrens()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('1 - admin');
        $moderator = $auth->getRole('2 - moderator');

        $adminPanel = $auth->getPermission('adminPanel');
        $assignment = $auth->getPermission('assignment');
        $moderation = $auth->getPermission('questionModeration');

        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $adminPanel);
        $auth->addChild($moderator, $adminPanel);
        $auth->addChild($admin, $assignment);
        $auth->addChild($moderator, $moderation);
    }

    public function actionAssignAdmin($id)
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('1 - admin');

        $auth->assign($admin, $id);
    }
}