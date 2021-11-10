<?php

use app\components\UrlGenHelper;
use app\components\questions\QuestionHtmlGen;
use yii\bootstrap4\LinkPager;
use yii\i18n\Formatter;
use yii\helpers\Html;

?>
<content id="index">
    <p class="upper_title_index"><?= Yii::t('main', 'Все вопросы') ?></p>

<?php if ($this->beginCache('category_parametrs', [
    'variations' => [Yii::$app->language],
    'duration' => 3600 * 24
])): 
?>
    <div class="category_block">
        <a href=<?= UrlGenHelper::categorySetting('new', @$tag_id) ?> class="category_setting new"><?= Yii::t('main', 'Новые вопросы') ?></a>
        <a href=<?= UrlGenHelper::categorySetting('interesting', @$tag_id) ?> class="category_setting interesting"><?= Yii::t('main', 'Интересные') ?></a>
        <a href=<?= UrlGenHelper::categorySetting('noanswer', @$tag_id) ?> class="category_setting noanswer"><?= Yii::t('main', 'Без ответа') ?></a>
    </div>
<?php $this->endCache(); endif ?>

    <div class="questions_block">
        <?php if ($questions): ?>
            <?php foreach ($questions as $question): ?>
                <div class="question">
                    <div class="info_block">
                        <?= QuestionHtmlGen::tagLinkGen($question) ?>
                        <span class="сomplexity"><?= QuestionHtmlGen::difficulty($question->difficulty) ?></span>

                        <p class="title"><a href=<?= UrlGenHelper::question($question->id) ?>><?= Html::encode($question->title) ?></a></p>

                        <div class="soc_info">
                            <span class="subscribes"><?= QuestionHtmlGen::subscribes($question) ?></span> |
                            <span class="pub_date"><?= (new Formatter)->asRelativeTime($question->pub_date) ?></span> |
                            <span class="viewed"><?= QuestionHtmlGen::views($question) ?></span> 
                        </div>
                    </div>

                    <?= QuestionHtmlGen::answersCount($question) ?>
                </div>
            <?php endforeach ?>
            
            <?=
                LinkPager::widget([
                    'pagination' => $pagination,
                ]); 
            ?>
        <?php else: ?>
            <p class="haven_answers"><?= Yii::t('main', 'Список вопросов пуст!') ?></p>
        <?php endif ?>
    </div>
</content>