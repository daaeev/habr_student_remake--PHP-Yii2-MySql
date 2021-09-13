<?php

namespace app\models;

use yii\base\Model;
use app\models\Question;

class AskForm extends Model 
{
    public $essence;
    public $tags;
    public $difficulty;
    public $content;

    public function rules()
    {
        return [
            [['essence', 'tags', 'content'], 'required'],
            [['content', 'difficulty', 'tags'], 'string'],
            [['essence'], 'string', 'max' => 100],
        ];
    }
    
    public function createQuestion()
    {
        if ($this->validate() && $this->saveInDb()) {
            return true;
        }
    }

    /*
       Creating and saving a question in the database
    */
    private function saveInDb()
    {
        $question = new Question;
        $question->title = $this->essence;
        $question->content = $this->content;
        $question->author_id = \Yii::$app->user->getId();
        $question->difficulty = $this->difficulty;
        if ($question->save()) {
            return true;
        }
    }

    public function attributeLabels()
    {
        return [
            'essence' => '',
            'tags' => '',
            'difficulty' => '',
            'content' => '',
        ];
    }
}