<?php

use app\components\UrlGenHelper;
use app\components\QuestionHtmlGen;
use yii\bootstrap4\LinkPager;
use yii\i18n\Formatter;

?>
<content id="index">
    <p class="upper_title_index">Все вопросы</p>

    <div class="category_block">
        <a href=<?= UrlGenHelper::categorySetting('new') ?> class="category_setting new">Новые вопросы</a>
        <a href=<?= UrlGenHelper::categorySetting('interesting') ?> class="category_setting interesting">Интересные</a>
        <a href=<?= UrlGenHelper::categorySetting('noanswer') ?> class="category_setting noanswer">Без ответа</a>
    </div>

    <div class="questions_block">
        
        <?php foreach ($questions as $question): ?>
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
                'pagination' => $pagination,
            ]); 
        ?>
    </div>
</content>