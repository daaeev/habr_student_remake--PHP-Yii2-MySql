<?php

use app\components\QuestionHelper;
use app\components\UrlGenHelper;
use app\components\QuestionHtmlGen;
use yii\i18n\Formatter;
use yii\helpers\Html;

?>

<content id="single">
    <div class="author_block">
        <a href=<?= UrlGenHelper::user($author->id) ?> class="author_img"><img src=<?= $author->getImage() ?> alt="author"></a>

        <div class="info_block">
            <a href=<?= UrlGenHelper::user($author->id) ?>><?= Html::encode($author->name) ?></a>
        </div>
    </div>

    <div class="question"> 
        <div class="tags">
            <?= QuestionHtmlGen::allTags($question->questionToTagTags) ?>
        </div>

        <p class="title"><?= Html::encode($question->title) ?></p>
        <p class="text"><?= $question->content ?></p>
        
        <div class="soc_info">
            <span>Вопрос задан <?= (new Formatter)->asRelativeTime($question->pub_date) ?></span>
            <span><?= QuestionHtmlGen::views($question) ?></span>
        </div>

        <div class="soc_buttons">
            <?= QuestionHtmlGen::subscribesButton($question) ?>
            <?= QuestionHtmlGen::commentsButton($comments['mainComments'], 'comments-btn main_comments-btn') ?>
        </div>

        <div class="comments_block main_comments">
            <?php foreach ($comments['mainComments'] as $comment): ?>
                <div class="comment">
                    <a href=<?= UrlGenHelper::user($comment->author->id) ?> class="author_img"><img src=<?= $comment->author->getImage() ?> alt="author_img"></a>

                    <div class="text_block">
                        <a class="author_name" href=""><?= Html::encode($comment->author->name) ?></a>
                        <p class="comment_content">
                            <?= $comment->content ?>
                        </p>
                        <p class="pub_date">Написано <?= (new Formatter)->asRelativeTime($comment->pub_date) ?></p>

                        <button type="button" class="answer-btn">Ответить</button>
                    </div>
                </div>
            <?php endforeach ?>
            
            <?= $this->renderFile('@app/views/partials/comment_form.php', ['model' => $model, 'question_id' => $question->id, 'type' => 1]) ?>

        </div>

        <div class="answers_container">
            <?php if (count($comments['answers']) > 0): ?>
            <?php QuestionHelper::getChildrenComments($comments['answers'], $comments['commentsToAnswers']) ?>
                <p class="header-under_text answers-count">Ответы на вопрос (<span><?= count($comments['answers']) ?></span>)</p>

                <div class="answers_block">
                    <?php foreach ($comments['answers'] as $Comment): ?>
                        <div class="answer">
                            <a href=<?= UrlGenHelper::user($Comment->author->id) ?> class="author_img"><img src=<?= $Comment->author->getImage() ?>></a>
                                
                            <div class="text_block">
                                <a class="author_name" href=<?= UrlGenHelper::user($Comment->author->id) ?>><?= Html::encode($Comment->author->name) ?></a>
                                <p class="answer_content">
                                    <span><?= $Comment->content ?></span>
                                    <?= $this->renderFile('@app/views/partials/edit_form.php', [
                                            'model' => $model, 
                                            'old_content' => $Comment->content,
                                            'comment_id' => $Comment->id,
                                        ]) 
                                    ?>
                                </p>
                                <p class="pub_date">Написано <?= (new Formatter)->asRelativeTime($Comment->pub_date) ?></p>
                                <input type="hidden" value="<?= $Comment->id ?>" class="comment_id">
                                <?= QuestionHtmlGen::likesButton($Comment) ?>
                                <?= QuestionHtmlGen::commentsButton($Comment->childComments, 'comments-btn') ?>
                                <?= QuestionHtmlGen::generateQuestionControlButtons($Comment, Yii::$app->view->params['user']) ?>

                                <div class="comments_block">
                                    <?php foreach ($Comment->childComments as $comment): ?>
                                        <div class="comment">
                                            <a href=<?= UrlGenHelper::user($comment->author->id) ?> class="author_img"><img src=<?= $comment->author->getImage() ?>></a>
                    
                                            <div class="text_block">
                                                <a class="author_name" href=<?= UrlGenHelper::user($comment->author->id) ?>><?= Html::encode($comment->author->name) ?></a>
                                                <p class="comment_content">
                                                    <?= $comment->content ?>
                                                </p>
                                                <p class="pub_date">Написано <?= (new Formatter)->asRelativeTime($comment->pub_date) ?></p>
                    
                                                <button type="button" class="answer-btn">Ответить</button>
                                            </div>
                                        </div>
                                    <?php endforeach ?>

                                    <?= $this->renderFile('@app/views/partials/comment_form.php', [
                                            'model' => $model, 
                                            'question_id' => $question->id,
                                            'parent_id' => $Comment->id,
                                        ]) 
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <p class="header-under_text">Ваш ответ на вопрос</p>
        </div>
        
    <?= $this->renderFile('@app/views/partials/answer_form.php', ['model' => $model, 'question_id' => $question->id]) ?>
    <?php if (QuestionHelper::checkUserHaveAnswer(Yii::$app->view->params['user'], $comments['answers'])): ?>
        <div class="user_have_answer">
            <img src="/public/img/have_answer.png" alt="have answer image">
            <p class="bold">Вы уже отвечали на вопрос</p>
            <p>Если хотите что-то добавить, то можете отредактировать свой ответ.</p>
        </div>
    <?php endif ?>

        <p class="header-under_text simillar">Похожие вопросы</p>
    </div>

    <div class="questions_block">
        <?php foreach ($similar_questions as $question): ?>
            <div class="question">
                <div class="info_block">
                    <?= QuestionHtmlGen::tagLinkGen($question) ?>
                    <span class="сomplexity"><?= QuestionHtmlGen::difficulty($question->difficulty) ?></span>

                    <p class="title"><a href=<?= UrlGenHelper::question($question->id) ?>><?= $question->title ?></a></p>

                    <div class="soc_info">
                        <span class="subscribes"><?= QuestionHtmlGen::subscribes($question) ?></span> |
                        <span class="pub_date"><?= (new Formatter)->asRelativeTime($question->pub_date) ?></span> |
                        <span class="viewed"><?= QuestionHtmlGen::views($question) ?></span> 
                    </div>
                </div>

                <a href=<?= UrlGenHelper::question($question->id) ?> class="answers"><?= QuestionHtmlGen::answers($question) ?></a>
            </div>
        <?php endforeach ?>
    </div>
</content>