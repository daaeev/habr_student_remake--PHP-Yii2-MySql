<?php

namespace app\models;

use yii\base\Model;
use app\models\Question;
use app\components\questions\QuestionHtmlGen;
use Yii;

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
        $user = Yii::$app->view->params['user']->id;

        $question = new Question;
        $question->title = $this->essence;
        $question->content = QuestionHtmlGen::contentProcessing($this->content);
        $question->tags = $this->tags;
        $question->author_id = $user->id;
        $question->difficulty = $this->difficulty;
        $user->updateAskTime();
        if ($question->save()) {
            return true;
        }
    }

    public function attributeLabels()
    {
        return [
            'essence' => Yii::t('main', 'Суть вопроса'),
            'tags' => Yii::t('main', 'Теги'),
            'difficulty' => Yii::t('main', 'Сложность'),
            'content' => Yii::t('main', 'Детали вопроса'),
        ];
    }
}