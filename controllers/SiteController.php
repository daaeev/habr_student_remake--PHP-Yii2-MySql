<?php

namespace app\controllers;

use Yii;
use app\models\AskForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\components\UrlGenHelper;
use app\components\questions\QuestionsGetHelper;
use app\components\tags\TagsGetHelper;
use app\components\questions\QuestionHelper;
use app\models\CommentsPosting;
use app\filters\NeededForSiteVariables;

class SiteController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create-question'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create-question'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'views' => [
                'class' => 'app\filters\ViewsCountFilter',
                'only' => ['single'],
            ],
            NeededForSiteVariables::class,
        ];
    }
    
    public function actionIndex($category = 'interesting')
    {
        $questions_data = QuestionsGetHelper::questionByCategoryIndex($category);

        return $this->render('index', [
            'questions' => $questions_data['elements'],
            'pagination' => $questions_data['pagination'],
        ]);
    }

    public function actionMy($category = 'interesting')
    {
        $questions_data = QuestionsGetHelper::questionByCategoryIndex($category, Yii::$app->view->params['user']->id);

        return $this->render('index', [
            'questions' => $questions_data['elements'],
            'pagination' => $questions_data['pagination'],
        ]);
    }

    public function actionSingle($id)
    {
        $question = QuestionsGetHelper::questionById($id);
        $author = $question->author;
        $comments = QuestionHelper::splitComments($question->comments);
        $similar_questions = QuestionsGetHelper::similarQuestionsByTag($question->id, $question->questionToTagTags[0]->tag_id);
        $model = new CommentsPosting;

        return $this->render('single', compact('question', 'author', 'comments', 'similar_questions', 'model'));
    }

    /*
       Displaying existing tags
    */
    public function actionTags()
    {
        $tags_data = TagsGetHelper::allTags();

        return $this->render('tags', [
            'tags' => $tags_data['elements'],
            'pagination' => $tags_data['pagination'],
        ]);
    }

    /*
       Displaying questions with the same tag
    */
    public function actionTag($id)
    {
        // -1, because the question with the specified id will not be displayed, which is not necessary
        $questions_data = QuestionsGetHelper::questionsByTag($id);

        return $this->render('index', [
            'questions' => $questions_data['elements'],
            'pagination' => $questions_data['pagination'],
        ]);
    }

    public function actionCreateQuestion()
    {
        $model = new AskForm;

        if ($model->load(Yii::$app->request->post(), 'AskForm') && $model->createQuestion()) {
            return $this->redirect(UrlGenHelper::home());
        }

        return $this->render('ask_question', compact('model'));
    }

    public function actionError()
    {
        $this->layout = 'error';

        $exception = Yii::$app->errorHandler->exception;
        if (!$exception) {
            return $this->redirect(UrlGenHelper::home());
        }
        
        $message = $exception->getMessage();

        return $this->render('error', compact('message'));
    }

    public function actionCommentCreate($question_id, $parent_id = null, $type = null)
    {
        if (Yii::$app->request->isPost) {
            if (QuestionHelper::validateGetData([
                    'referer_url' => $_SERVER['HTTP_REFERER'], 
                    'question_id' => $question_id,
                    'parent_id' => $parent_id,
                    'type' => $type,
                ], 'create')
            ) {
                $model = new CommentsPosting;
                
                if ($model->load(Yii::$app->request->post(), 'CommentsPosting')) {
                    $model->createComment($question_id, $parent_id, $type);
                }
            }
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
