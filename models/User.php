<?php

namespace app\models;

use app\components\user\UserHelper;
use yii\helpers\Html;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\web\MethodNotAllowedHttpException;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    use \app\components\behaviors\GetImageBehavior;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            ['image', 'default', 'value' => 'author.jpg'],
            [['can_ask_time'], 'default', 'value' => time()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'description' => 'Description',
            'ban_reason' => 'Ban Reason',
            'contribution' => 'Contribution',
            'can_ask_time' => 'Can ask time',
        ];
    }

    public function setDescription($description)
    {
        $this->description = $description;
        $this->save(false);
    }

    public function updateAskTime()
    {
        $this->can_ask_time = UserHelper::generateTime($this);
        $this->save(false);
    }

    public function canAskByTime()
    {
        if ($this->can_ask_time < time())
            return true;

        throw new HttpException(400, 'Вы сможете задать следующий вопрос через ' . UserHelper::translateTime($this->can_ask_time));
    }

    public function updateContribution($num)
    {
        $this->updateCounters(['contribution' => $num]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO...
    }

    public function getAuthKey()
    {
        // TODO...
    }

    public function validateAuthKey($authKey)
    {
        // TODO...
    }

    public function getComments()
    {
        return $this->hasMany(Comments::class, ['author_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['author_id' => 'id']);
    }

    public function getUserToCommentLikes()
    {
        return $this->hasMany(UserToCommentLike::class, ['user_id' => 'id']);
    }

    public function getUserToQuestionSubs()
    {
        return $this->hasMany(UserToQuestionSub::class, ['user_id' => 'id']);
    }

    public function getUserToTagSubs()
    {
        return $this->hasMany(UserToTagSub::class, ['user_id' => 'id']);
    }

    public function getUserToCommentComplaints()
    {
        return $this->hasMany(UserToCommentComplaint::class, ['user_id' => 'id']);
    }
}
