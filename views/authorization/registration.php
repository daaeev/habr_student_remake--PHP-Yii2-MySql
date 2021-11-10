<?php

use app\components\UrlGenHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php if ($this->beginCache('reg_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
<div class="registration_block">
    <p class="title"><?= Yii::t('main', 'Регистрация') ?></p>

    <div class="register_with_soc">
        <p><?= Yii::t('main', 'C помощью сервиса') ?></p>

        <a class="soc_links facebook" href=""><i class="bi bi-facebook"></i></a>
        <a class="soc_links gmail" href=""><i class="bi bi-google"></i></a>
    </div>

    <?php $form = ActiveForm::begin() ?>

    <div class="field">
        <?= $form->field($model, 'email') ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'login')->input('text', ['autocomplete' => 'off']) ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>

    <div class="field">
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
    </div>

    <?= Html::submitButton(Yii::t('main', 'Зарегистрироваться')) ?>

    <?php ActiveForm::end() ?>

</div>

<p class="authorization_link"><?= Yii::t('main', 'Уже зарегистрированы?') ?> <a href=<?= UrlGenHelper::login() ?>><?= Yii::t('main', 'Войдите') ?></a></p>
<?php $this->endCache(); endif ?>