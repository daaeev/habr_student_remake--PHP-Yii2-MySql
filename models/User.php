<?php

namespace app\models;

use app\components\ImageInterface;
use yii\web\IdentityInterface;
use Yii;

class User extends \yii\db\ActiveRecord implements 
    IdentityInterface,
    ImageInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            ['image', 'default', 'value' => 'author.png'],
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
        ];
    }

    public function getImage(): string
    {
        return Yii::getAlias('@web') . 'uploads/users/' . $this->image;
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
}
