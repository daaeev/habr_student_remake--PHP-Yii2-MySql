<?php 

use app\components\UrlGenHelper;
use yii\widgets\ActiveForm;
use app\components\QuestionHtmlGen;

if (!\Yii::$app->user->isGuest): 
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
                    'action' => '/site/comment-create?' . 'question_id=' . $question_id . (@$parent_id ? '&parent_id=' . $parent_id : '') . (@$type ? '&type=' . $type : ''),
                    'method' => 'POST',
                ]) ?>
                    <?= $form->field($model, 'content')->textarea()->label('') ?>
                    <button type="submit">Опубликовать</button>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php endif ?>
