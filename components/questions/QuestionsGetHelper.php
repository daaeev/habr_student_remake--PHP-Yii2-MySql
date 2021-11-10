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
    /*
       Getting questions for different pages regarding the selected category
    */
    public static function questionsByCategory($category, $pageName, $user_id = null, $tag_id = null)
    {
        $query = Question::find()
            ->where(['!=', 'status', 0])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments.userToCommentLikes', 'userToQuestionViews');

        /*
           Adding query parameters based on the page
        */
        if ($pageName == 'my'):
            $tags_id_array = UserToTagSub::find()
                ->select(['tag_id'])
                ->andWhere(['user_id' => $user_id])
                ->all();

            $query
                ->joinWith('questionToTagTags tags');
                
            foreach ($tags_id_array as $tag_id)
                $query->andWhere(['tags.tag_id' => $tag_id]);

        elseif ($pageName == 'by_tag'):
            $query
                ->joinWith('questionToTagTags QuesToTag')
                ->andWhere(['QuesToTag.tag_id' => $tag_id]);
        endif;

        /*
           Adding query parameters based on category
        */
        switch ($category):
            case 'interesting':
                $query
                    ->orderBy('views DESC');
                break;

            case 'new':
                $query
                    ->orderBy('id DESC');
                break;

            case 'noanswer':
                $query
                    ->joinWith('comments')
                    ->andWhere(['comments.question_id' => null]) 
                    ->orderBy('id DESC');
                break;
        endswitch;

        $data = self::getPaginationData($query);

        return $data;
    }

    /*
       Receives the last 24 hours questions
    */
    public static function sidebarQuestions()
    {
        $questions = Question::find()
            ->where(['!=', 'status', 0])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments')
            ->andWhere(['>=', 'pub_date', new Expression('UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)')])
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
            ->with('author', 'comments.author', 'comments.question', 'comments.userToCommentLikes', 'questionToTagTags.tag', 'userToQuestionSubs', 'userToQuestionViews')
            ->one();

        /*
           Ban check
        */
        if ($model) {
            if ($model->status == 2) {
                throw new NotFoundHttpException('Вопрос забанен: ' . $model->ban_reason);
            }

            return $model;
        }

        throw new NotFoundHttpException('Вопрос не найден');
    }

    public static function questionsByAuthor($author)
    {
        $query = Question::find()
            ->where(['!=', 'status', 0])
            ->andWhere(['author_id' => $author->id])
            ->with('questionToTagTags.tag', 'userToQuestionSubs', 'comments', 'userToQuestionViews')
            ->orderBy('id DESC');

            $data = self::getPaginationData($query);

            return $data;
    }

    /*
       Finds a question by tag
    */
    public static function similarQuestionsByTag($question_id, $tag_id)
    {
        $questions = Question::find()
            ->joinWith('questionToTagTags tags')
            ->where(['tags.tag_id' => $tag_id])
            ->andWhere(['!=', 'status', 0])
            ->andWhere(['!=', 'question.id', $question_id])
            ->with('comments', 'userToQuestionSubs', 'questionToTagTags.tag', 'userToQuestionViews')
            ->limit(10)
            ->all();
        
        return $questions;
    }
}