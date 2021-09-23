<?php

namespace app\components;

use app\models\Question;
use yii\data\Pagination;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/*
   Class for getting the question, 
   depending on the requested type using pagination
*/
class QuestionsGetHelper
{
    /*
       Receives the most viewed questions
    */
    public static function interesting()
    {
        $questions_query = Question::find()
            ->where(['status' => 1])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments')
            ->orderBy('viewed DESC');
        $data = self::getPaginationData($questions_query);
        
        return $data;
    }

    /*
       Gets the most recent questions
    */
    public static function new()
    {
        $questions_query = Question::find()
            ->where(['status' => 1])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments')
            ->orderBy('id DESC');
        $data = self::getPaginationData($questions_query);
        
        return $data;
    }

    /*
       Gets unanswered questions
    */
    public static function noanswer()
    {
        $questions_query = Question::find()
            ->joinWith('comments')
            ->where(['status' => 1, 'comments.question_id' => null])
            ->with('questionToTagTags.tag', 'userToQuestionSubs')
            ->orderBy('id DESC');
        $data = self::getPaginationData($questions_query);
        
        return $data;
    }

    /*
       Algorithm for creating pagination described in the documentation
    */
    private static function getPaginationData($query)
    {
        $countQuery = $query->count();
        $pagination = new Pagination(['totalCount' => $countQuery, 'pageSize' => 20]);
        $questions = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return compact('pagination', 'questions');
    }

    /*
       Receives the last 24 hours questions
    */
    public static function sidebarQuestions()
    {
        $questions = Question::find()
            ->where(['status' => 1])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments')
            ->where(['>=', 'pub_date', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
            ->limit(10)
            ->all();

        return $questions;
    }

    /*
       Finds a question by id
    */
    public static function questionById($id)
    {
        $model = Question::find()
            ->where(['id' => $id])
            ->andWhere(['!=', 'status', 0])
            ->with('author', 'comments.author', 'comments.userToCommentLikes', 'questionToTagTags.tag', 'userToQuestionSubs')
            ->one();

        /*
           Ban check
        */
        if ($model) {
            if ($model->status == 2) {
                throw new NotFoundHttpException($model->ban_reason);
            }

            return $model;
        } else {
            throw new NotFoundHttpException('Вопрос обрабатывается');
        }

        throw new NotFoundHttpException('Вопрос не найден');
    }

    /*
       Finds a question by tag
    */
    public static function questionByTag($question_id, $tag_id)
    {
        $questions = Question::find()
            ->joinWith('questionToTagTags tags')
            ->where(['tags.tag_id' => $tag_id, 'status' => 1])
            ->andWhere(['!=', 'question.id', $question_id])
            ->with('comments', 'userToQuestionSubs')
            ->limit(10)
            ->all();
        
        return $questions;
    }
}