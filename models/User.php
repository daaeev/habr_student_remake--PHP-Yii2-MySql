<?php

namespace app\models;

use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
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
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
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
}
