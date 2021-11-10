<?php

use app\components\UrlGenHelper; 
use app\components\questions\QuestionHtmlGen;
use app\components\user\UserGetHelper;
use yii\i18n\Formatter;
use yii\helpers\Html;
use yii\bootstrap4\LinkPager;

$comments_data = UserGetHelper::getAnswers($user->id);
?>
<?php if ($comments_data['elements']): ?>
    <div class="answers_block">
        <?php foreach ($comments_data['elements'] as $Comment): ?>
            <p class="title"><a href=<?= UrlGenHelper::question($Comment->question->id) ?>><?= $Comment->question->title ?></a></p>
            <div class="answer">
                <a href=<?= UrlGenHelper::user($Comment->author->id) ?> class="author_img"><img src=<?= $Comment->author->getImage() ?>></a>
                    
                <div class="text_block">
                    <a class="author_name" href=<?= UrlGenHelper::user($Comment->author->id) ?>><?= Html::encode($Comment->author->name) ?></a>
                    <p class="answer_content">
                        <span><?= $Comment->content ?></span>
                    </p>
                    <p class="pub_date"><?= Yii::t('main', 'Написано') ?> <?= (new Formatter)->asRelativeTime($Comment->pub_date) ?></p>
                    <input type="hidden" value="<?= $Comment->id ?>" class="comment_id field_for_auth">
                    <?= QuestionHtmlGen::likesButton($Comment) ?>
                </div>
            </div>
        <?php endforeach ?>

        <?=
            LinkPager::widget([
                'pagination' => $comments_data['pagination'],
            ]); 
        ?>
    </div>
<?php else: ?>
    <div class="empty_block">
        <p class="empty"><?= Yii::t('main', 'Пользователь не оставлял ответов!') ?></p>
    </div>
<?php endif ?>