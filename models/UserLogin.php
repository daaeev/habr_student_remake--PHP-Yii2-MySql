<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class UserLogin extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class],
            ['password', 'string', 'min' => '6'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = User::findOne(['email' => $this->email]);

            /*
               If the passwords match - authorize, otherwise issue an error
            */
            if (Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {
                Yii::$app->user->login($user);
                
                return true;
            }
    
            $this->addError('password', 'Wrong password');
        }
    }
}