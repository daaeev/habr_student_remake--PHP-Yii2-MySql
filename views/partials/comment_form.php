<?php 

use app\components\UrlGenHelper;
use yii\widgets\ActiveForm;
use app\components\questions\QuestionHtmlGen;
use yii\helpers\Url;

if (!\Yii::$app->user->isGuest && $this->params['user']->status != 3): 
?>
<?php if ($this->beginCache('comment_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
    <div class="comment_form_block">
        <a href=<?= UrlGenHelper::user($this->params['user']->id) ?> class="author_img"><img src=<?= $this->params['user']->getImage() ?>></a>

        <div class="form_block">
            <a class="author_name" href=<?= UrlGenHelper::user($this->params['user']->id) ?>><?= $this->params['user']->name ?></a>
            <div class="single_form">
                <div class="form_helper">
                    <?= QuestionHtmlGen::generateFormHelpButtons() ?>
                </div>

                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['comment-create', 'question_id' => $question_id, 'parent_id' => @$parent_id, 'type' => @$type]),
                    'method' => 'POST',
                    'id' => 'form',
                ]) ?>
                    <?= $form->field($model, 'content')->textarea()->label('') ?>
                    <button type="submit"><?= Yii::t('main', 'Опубликовать') ?></button>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php $this->endCache(); endif ?>
<?php endif ?>
