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
        /*
           If the validation is successful, create a user and authorize him
        */
        if ($this->validate()) {
            $user = $this->createUserFromForm();
            Yii::$app->user->login($user);
            
            return true;
        }
    }

    private function createUserFromForm(): User
    {
        $user = new User;
        $user->name = $this->login;
        $user->email = $this->email;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->save();

        return $user;
    }
}