<?php

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
        <p class="text"><?= Html::encode($question->content) ?></p>
        
        <div class="soc_info">
            <span>Вопрос задан <?= (new Formatter)->asRelativeTime($question->pub_date) ?></span>
            <span><?= QuestionHtmlGen::views($question) ?></span>
        </div>

        <div class="soc_buttons">
            <?= QuestionHtmlGen::subscribesButton($question) ?>
            <button class="comments-btn main_comments-btn"><?= QuestionHtmlGen::commentsButton($comments['mainComments']) ?></button>
        </div>

        <div class="comments_block main_comments">
            <?php foreach ($comments['mainComments'] as $comment): ?>
                <div class="comment">
                    <a href=<?= UrlGenHelper::user($comment->author->id) ?> class="author_img"><img src=<?= $comment->author->getImage() ?> alt="author_img"></a>

                    <div class="text_block">
                        <a class="author_name" href=""><?= Html::encode($comment->author->name) ?></a>
                        <p class="comment_content">
                            <?= Html::encode($comment->content) ?>
                        </p>
                        <p class="pub_date">Написано <?= (new Formatter)->asRelativeTime($comment->pub_date) ?></p>

                        <button type="button" class="answer-btn">Ответить</button>
                    </div>
                </div>
            <?php endforeach ?>
            
            <?= $this->renderFile('@app/views/partials/comment_form.php', compact('model')) ?>

        </div>

        <div class="answers_container">
            <?php if (count($comments['answers']) > 0): ?>
                <p class="header-under_text">Ответы на вопрос (<?= count($comments['answers']) ?>)</p>

                <div class="answers_block">
                    <?php foreach ($comments['answers'] as $comment): ?>
                        <div class="answer">
                            <a href=<?= UrlGenHelper::user($comment->author->id) ?> class="author_img"><img src=<?= $comment->author->getImage() ?>></a>

                            <div class="text_block">
                                <a class="author_name" href=<?= UrlGenHelper::user($comment->author->id) ?>><?= Html::encode($comment->author->name) ?></a>
                                <p class="answer_content">
                                    <?= Html::encode($comment->content) ?>
                                </p>
                                <p class="pub_date"><?= (new Formatter)->asRelativeTime($comment->pub_date) ?></p>

                                <?= QuestionHtmlGen::likesButton($comment) ?>
                                <button class="comments-btn"><?= QuestionHtmlGen::commentsButton($comments['answers']) ?></button>

                                <div class="comments_block">
                                    <?php foreach ($comments['answers'] as $comment): ?>
                                        <div class="comment">
                                            <a href=<?= UrlGenHelper::user($comment->author->id) ?> class="author_img"><img src=<?= $comment->author->getImage() ?>></a>
                    
                                            <div class="text_block">
                                                <a class="author_name" href=<?= UrlGenHelper::user($comment->author->id) ?>><?= Html::encode($comment->author->name) ?></a>
                                                <p class="comment_content">
                                                    <?= Html::encode($comment->content) ?>
                                                </p>
                                                <p class="pub_date">Написано <?= (new Formatter)->asRelativeTime($comment->pub_date) ?></p>
                    
                                                <button type="button" class="answer-btn">Ответить</button>
                                            </div>
                                        </div>
                                    <?php endforeach ?>

                                    <?= $this->renderFile('@app/views/partials/comment_form.php', compact('model')) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>

            <p class="header-under_text">Ваш ответ на вопрос</p>
        </div>

        <?= $this->renderFile('@app/views/partials/answer_form.php', compact('model')) ?>

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