<?php

namespace app\models;

use yii\base\Model;

class CommentsPosting extends Model
{
    public $content;

    public function attributeLabels()
    {
        return [
            'content' => '',
        ];
    }
}