<?php

use app\components\questions\QuestionHtmlGen;
use app\components\questions\QuestionsGetHelper;
use app\components\UrlGenHelper;
use yii\i18n\Formatter;
use yii\bootstrap4\LinkPager;

$questions_data = QuestionsGetHelper::questionsByAuthor($user);
?>
<div class="questions_block">
    <?php foreach ($questions_data['elements'] as $question): ?>
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
            
    <?=
        LinkPager::widget([
            'pagination' => $questions_data['pagination'],
        ]); 
    ?>
</div>