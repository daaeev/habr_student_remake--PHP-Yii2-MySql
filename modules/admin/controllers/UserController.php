<?php

namespace app\modules\admin\controllers;

use Yii;
use app\components\RoleHelper;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
   public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRole($id)
    {
        $roles = RoleHelper::getRoles();

        /*
           Role attachment if the form was submitted
        */
        if ($attributes = Yii::$app->request->post()) {
            Yii::$app->authManager->revokeAll($id);
            $user = $this->findModel($attributes['user_id']);

            RoleHelper::setUserRole($attributes['role'], $attributes['user_id']);
            RoleHelper::setUserStatus($user, $roles, $attributes['role'], $attributes['ban_reason']);

            return $this->redirect(['/admin/user/view', 'id' => $attributes['user_id']]);
        }

        return $this->render('role', compact('id', 'roles'));
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден');
    }
}
