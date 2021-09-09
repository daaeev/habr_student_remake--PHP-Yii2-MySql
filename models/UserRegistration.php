<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class UserRegistration extends Model
{
    public $login;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['login', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'unique', 'targetClass' => User::class],
            ['email', 'email'],
            ['login', 'string', 'min' => '4'],
            ['password', 'string', 'min' => '6'],
            ['password', 'compare'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Nickname',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Confirm password',
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            $user = $this->createUser();
            Yii::$app->user->login($user);
            return true;
        }
    }

    public function createUser()
    {
        $user = new User;
        $user->name = $this->login;
        $user->email = $this->email;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->save();

        return $user;
    }
}