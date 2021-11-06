<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class ChangePassword extends Model
{
    public $old_password;
    public $new_pasword;
    public $confirm_password;

    public function rules()
    {
        return [
            [['new_pasword', 'old_password', 'confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_pasword'],
            ['new_pasword', 'compare', 'compareAttribute' => 'old_password', 'operator' => '!='],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => Yii::t('main', 'Старый пароль'),
            'new_pasword' => Yii::t('main', 'Новый пароль'),
            'confirm_password' => Yii::t('main', 'Подтвердите пароль'),
        ];
    }
}