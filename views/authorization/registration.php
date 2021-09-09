<?php

use app\components\UrlGenHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="registration_block">
    <p class="title">Регистрация</p>

    <div class="register_with_soc">
        <p>C помощью сервиса</p>

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

    <?= Html::submitButton('Зарегистрироваться') ?>

    <?php ActiveForm::end() ?>

</div>

<p class="authorization_link">Уже зарегистрированы? <a href=<?= UrlGenHelper::login() ?>>Войдите</a></p>