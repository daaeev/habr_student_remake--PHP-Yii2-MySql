<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php if ($this->beginCache('change_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
<div class="change_form_block">
    <p class="title"><?= Yii::t('main', 'Изменить пароль') ?></p>

    <?php $form = ActiveForm::begin() ?>

    <div class="field">
        <?= $form->field($model, 'old_password', ['options' => ['class' => ['old_pass']]])->input('text') ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'new_pasword')->passwordInput() ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'confirm_password', ['options' => ['class' => ['new_pass']]])->passwordInput() ?>
    </div>

    <?= Html::submitButton(Yii::t('main', 'Изменить пароль')) ?>

    <?php ActiveForm::end() ?>
</div>
<?php $this->endCache(); endif ?>