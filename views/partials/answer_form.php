<?php 

use app\components\UrlGenHelper;
use yii\widgets\ActiveForm;

if (!\Yii::$app->user->isGuest): 
?>
    <div class="answer_form_block">
        <a href=<?= UrlGenHelper::user($this->params['user']->id) ?> class="author_img"><img src=<?= $this->params['user']->getImage() ?>></a>

        <div class="form_block">
            <a class="author_name" href=<?= UrlGenHelper::user($this->params['user']->id) ?>><?= $this->params['user']->name ?></a>
            <div class="single_form">
                <div class="form_helper">
                    <button type="button">B</button>
                    <button type="button">B</button>
                    <button type="button">B</button>
                </div>

                <?php $form = ActiveForm::begin([
                    'action' => '/handler/comment?' . 'question_id=' . $question_id,
                    'method' => 'POST',
                ]) ?>
                    <?= $form->field($model, 'content')->textarea()->label('') ?>
                    <button type="submit">Опубликовать</button>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <p class="auth">Вы не авторизованы! <a href=<?= UrlGenHelper::login() ?>>Войдите</a></p>
<?php endif ?>