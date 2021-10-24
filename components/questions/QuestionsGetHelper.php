<?php

namespace app\components\questions;

use app\models\Question;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use app\components\lib\GetHelperClass;
use app\models\UserToTagSub;

/*
   Class for getting the question, 
   depending on the requested type using pagination
*/
class QuestionsGetHelper extends GetHelperClass
{
    public static function questionByCategoryIndex($category)
    {
        $query = Question::find()
            ->cache(100)
            ->where(['status' => 1]);

        switch ($category):
            case 'interesting':
                $query = $query
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
                    ->orderBy('views DESC');
                break;

            case 'new':
                $query = $query
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
                    ->orderBy('id DESC');
                break;

            case 'noanswer':
                $query = $query
                    ->joinWith('comments')
                    ->andWhere(['comments.question_id' => null])
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'userToQuestionViews')
                    ->orderBy('id DESC');
                break;
        endswitch;

        $data = self::getPaginationData($query);

        return $data;
    }

    public static function questionByCategoryMy($category, $user_id)
    {
        $tags_id_array = UserToTagSub::find()
            ->select(['id'])
            ->where(['user_id' => $user_id])
            ->all();

        $query = Question::find()
            ->cache(100)
            ->where(['status' => 1])
            ->joinWith('questionToTagTags tags')
            ->andWhere(['tags.tag_id' => 36]);


        switch ($category):
            case 'interesting':
                $query = $query
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
                    ->orderBy('views DESC');
                break;

            case 'new':
                $query = $query
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
                    ->orderBy('id DESC');
                break;

            case 'noanswer':
                $query = $query
                    ->joinWith('comments')
                    ->andWhere(['comments.question_id' => null])
                    ->with('questionToTagTags.tag', 'userToQuestionSubs', 'userToQuestionViews')
                    ->orderBy('id DESC');
                break;
        endswitch;

        $data = self::getPaginationData($query);

        return $data;
    }

    /*
       Get a question for a given tag
    */
    public static function questionsByTag($tag_id)
    {
        $questions_query = Question::find()
            ->cache(100)
            ->joinWith('questionToTagTags QuesToTag')
            ->where(['status' => 1])
            ->andWhere(['QuesToTag.tag_id' => $tag_id])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
            ->orderBy('id DESC');

        $data = self::getPaginationData($questions_query);
        
        return $data;
    }

    /*
       Receives the last 24 hours questions
    */
    public static function sidebarQuestions()
    {
        $questions = Question::find()
            ->cache(100)
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
            ->with('author', 'comments.author', 'comments.userToCommentLikes', 'questionToTagTags.tag', 'userToQuestionSubs', 'userToQuestionViews')
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
    public static function similarQuestionsByTag($question_id, $tag_id)
    {
        $questions = Question::find()
            ->cache(100)
            ->joinWith('questionToTagTags tags')
            ->where(['tags.tag_id' => $tag_id, 'status' => 1])
            ->andWhere(['!=', 'question.id', $question_id])
            ->with('comments', 'userToQuestionSubs', 'questionToTagTags.tag', 'userToQuestionViews')
            ->limit(10)
            ->all();
        
        return $questions;
    }
}